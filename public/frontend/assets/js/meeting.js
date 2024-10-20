const videoContainer = document.querySelector("#videos");

const vm = new Vue({
    el: "#app",
    data: {
        userToken: "",
        roomId: "",
        roomToken: "",
        room: undefined,
        callClient: undefined,
        roomIdCopied: false, 
        roomUrlCopied: false, 
        isRecording: false, 
        mediaRecorder: null, 
        recordedChunks: [], 
    },
    computed: {
        roomUrl: function () {
            return `http://127.0.0.1:8000/meeting/?room=${this.roomId}`;
        },
    },
    async mounted() {
        api.setRestToken();

        const urlParams = new URLSearchParams(location.search);
        const roomId = urlParams.get("room");
        if (roomId) {
            this.roomId = roomId;

            await this.join();
        }
    },
    methods: {
        authen: function () {
            return new Promise(async (resolve) => {
                const userId = `${(Math.random() * 100000).toFixed(6)}`;
                const userToken = await api.getUserToken(userId);
                this.userToken = userToken;

                if (!this.callClient) {
                    const client = new StringeeClient();

                    client.on("authen", function (res) {
                        // console.log("on authen: ", res);
                        resolve(res);
                    });
                    this.callClient = client;
                }
                this.callClient.connect(userToken);
            });
        },

        copyToClipboard: function (text, copiedField) {
            navigator.clipboard
                .writeText(text)
                .then(() => {
                    this[copiedField] = true; // Hiển thị thông báo copy

                    // Ẩn thông báo sau 2 giây
                    setTimeout(() => {
                        this[copiedField] = false;
                    }, 2000);
                })
                .catch((err) => {
                    // console.error("Không thể copy text: ", err);
                });
        },

        publish: async function (screenSharing = false) {
            const localTrack = await StringeeVideo.createLocalVideoTrack(
                this.callClient,
                {
                    audio: true,
                    video: true,
                    screen: screenSharing,
                    videoDimensions: { width: 640, height: 360 },
                }
            );

            const videoElement = localTrack.attach();
            this.addVideo(videoElement);

            const roomData = await StringeeVideo.joinRoom(
                this.callClient,
                this.roomToken
            );
            const room = roomData.room;
            // console.log({ roomData, room });

            if (!this.room) {
                this.room = room;
                room.clearAllOnMethos();
                room.on("addtrack", (e) => {
                    const track = e.info.track;

                    // console.log("addtrack", track);
                    if (track.serverId === localTrack.serverId) {
                        // console.log("local");
                        return;
                    }
                    this.subscribe(track);
                });
                room.on("removetrack", (e) => {
                    const track = e.track;
                    if (!track) {
                        return;
                    }

                    const mediaElements = track.detach();
                    mediaElements.forEach((element) => element.remove());
                });

                // Join existing tracks
                roomData.listTracksInfo.forEach((info) => this.subscribe(info));
            }

            await room.publish(localTrack);
            // console.log("room publish successful");
        },
        createRoom: async function () {
            const room = await api.createRoom();
            const { roomId } = room;
            const roomToken = await api.getRoomToken(roomId);

            this.roomId = roomId;
            this.roomToken = roomToken;
            // console.log({ roomId, roomToken });

            await this.authen();
            await this.publish();
        },
        join: async function () {
            const roomToken = await api.getRoomToken(this.roomId);
            this.roomToken = roomToken;

            await this.authen();
            await this.publish();
        },
        joinWithId: async function () {
            const roomId = prompt("Dán Room ID vào đây nhé!");
            if (roomId) {
                this.roomId = roomId;
                await this.join();
            }
        },
        subscribe: async function (trackInfo) {
            const track = await this.room.subscribe(trackInfo.serverId);
            track.on("ready", () => {
                const videoElement = track.attach();
                this.addVideo(videoElement);
            });
        },
        addVideo: function (video) {
            video.setAttribute("controls", "true");
            video.setAttribute("playsinline", "true");
            videoContainer.appendChild(video);
        },
        endCall: function () {
            if (this.callClient) {
                this.callClient.disconnect();
            }

            if (this.room) {
                this.room
                    .leave()
                    .then(() => {
                        this.room = undefined;
                        // Chuyển hướng về trang http://127.0.0.1:8000/meeting
                        window.location.href = "http://127.0.0.1:8000/meeting";
                    })
                    .catch((error) => {
                        // console.error("Có lỗi khi rời khỏi phòng: ", error);
                        // Vẫn reset trang trong trường hợp có lỗi
                        window.location.href = "http://127.0.0.1:8000/meeting";
                    });
            } else {
                // Nếu không có phòng, chuyển hướng ngay lập tức
                window.location.href = "http://127.0.0.1:8000/meeting";
            }
        },
        toggleScreenRecording: async function () {
            if (this.isRecording) {
                // Dừng ghi màn hình
                this.mediaRecorder.stop();
                this.isRecording = false;
            } else {
                // Bắt đầu ghi màn hình
                try {
                    // Lấy stream màn hình
                    const displayStream =
                        await navigator.mediaDevices.getDisplayMedia({
                            video: true,
                            audio: true, // Ghi âm thanh hệ thống
                        });

                    // Lấy stream từ microphone
                    const audioStream =
                        await navigator.mediaDevices.getUserMedia({
                            audio: true, // Ghi âm thanh từ microphone
                        });

                    // Kết hợp video và audio stream
                    const combinedStream = new MediaStream([
                        ...displayStream.getTracks(),
                        ...audioStream.getTracks(),
                    ]);

                    this.recordedChunks = [];
                    this.mediaRecorder = new MediaRecorder(combinedStream);

                    this.mediaRecorder.ondataavailable = (event) => {
                        if (event.data.size > 0) {
                            this.recordedChunks.push(event.data);
                        }
                    };

                    this.mediaRecorder.onstop = () => {
                        const blob = new Blob(this.recordedChunks, {
                            type: "video/webm",
                        });
                        const url = URL.createObjectURL(blob);

                        // Tạo tên file theo định dạng giờ, phút, giây, ngày, tháng, năm
                        const now = new Date();
                        const timestamp = now
                            .toLocaleString("vi-VN", {
                                year: "numeric",
                                month: "2-digit",
                                day: "2-digit",
                                hour: "2-digit",
                                minute: "2-digit",
                                second: "2-digit",
                            })
                            .replace(/\//g, "-")
                            .replace(",", "")
                            .replace(/:/g, "-");

                        const fileName = `recording-${timestamp}.webm`;

                        const a = document.createElement("a");
                        a.style.display = "none";
                        a.href = url;
                        a.download = fileName; // Đặt tên file
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    };

                    this.mediaRecorder.start();
                    this.isRecording = true;
                } catch (err) {
                    console.error("Error: " + err);
                }
            }
        },
    },
});
