@extends('layouts.client.app')

@section('meta_title', 'Chẩn Đoán Y Tế')

@section('content')

    <style>
        .page {
            background-image: url('http://127.0.0.1:8000/frontend/assets/image/background-diagnosis.png');
        }

        .diagnosis-container {
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 10%;
            border: 1px solid #03B75F;
            background-color: #fff;
        }

        .diagnosis-title {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 2rem;
        }

        .btn {
            display: flex;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .input-field,
        .input-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;

            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-field:focus,
        .input-select:focus {
            border-color: #03B75F;
            outline: none;
            box-shadow: 0 0 5px #03B75F;
        }

        .record-button,
        .submit-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;

            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .record-button {
            margin-left: 5px
        }

        .record-button:hover,
        .submit-button:hover {
            background-color: #218838;
        }

        .microphone-icon {
            width: 24px;
            height: 24px;
            background-image: url('microphone-icon.png');
            background-size: cover;
            margin-right: 8px;
        }

        .diagnosis-output {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;

            color: #333;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .warning {
            font-size: 11px;
            color: red;
        }
    </style>

    <div class="diagnosis-container">
        <h1 class="diagnosis-title">Chẩn Đoán Y Tế</h1>
        <div class="input-group">
            <label for="age" class="input-label">Tuổi:</label>
            <input type="number" id="age" class="input-field" placeholder="Nhập tuổi" required />
        </div>
        <div class="input-group">
            <label for="sex" class="input-label">Giới tính:</label>
            <select id="sex" class="input-select">
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
            </select>
        </div>
        <div class="input-group">
            <label for="symptoms" class="input-label">Triệu chứng:</label>
            <textarea required id="symptoms" class="input-field" placeholder="Nhập triệu chứng hoặc nhấn nút ghi âm..."
                rows="4"></textarea>
        </div>

        <label for="diagnosis" class="input-label">Kết quả chuẩn đoán</label>
        <span class="warning">*Đây chỉ là kết quả chuẩn đoán, vui lòng đến bệnh viện được bác sĩ đưa ra kết quả chính xác
            hơn</span>
        <div id="diagnosis" class="diagnosis-output" aria-placeholder="Kết quả chuẩn đoán ...">
            <table id="diagnosisTable" style="display:none;">
                <thead>
                    <tr>
                        <th>Tên bệnh</th>
                        <th>Xác suất</th>
                    </tr>
                </thead>
                <tbody id="diagnosisBody">
                    <!-- Kết quả chẩn đoán sẽ được thêm vào đây -->
                </tbody>
            </table>
        </div>

        <div class="btn">
            <button style="width:60%" type="submit" id="submitBtn" class="submit-button">Chuẩn đoán</button>
            <button style="width:40%" id="recordBtn" class="record-button">
                <i style="margin-right:5%:" class="fa-solid fa-microphone"></i>
            </button>
        </div>


    </div>

    <script>
        const diagnosisEl = document.getElementById("diagnosis");
        const recordBtn = document.getElementById("recordBtn");
        const submitBtn = document.getElementById("submitBtn");
        const symptomsInput = document.getElementById("symptoms");
        const diagnosisTable = document.getElementById("diagnosisTable");
        const diagnosisBody = document.getElementById("diagnosisBody");

        let recognition;
        if ("webkitSpeechRecognition" in window) {
            recognition = new webkitSpeechRecognition();
        } else if ("SpeechRecognition" in window) {
            recognition = new SpeechRecognition();
        } else {
            alert("Trình duyệt của bạn không hỗ trợ nhận dạng giọng nói.");
        }

        if (recognition) {
            recognition.lang = "vi-VN";
            recognition.continuous = false;
            recognition.interimResults = false;

            recognition.onstart = function() {
                recordBtn.textContent = "Đang ghi âm..";
                recordBtn.classList.add("recording");
            };

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                symptomsInput.value = transcript; // Điền văn bản vào ô text
            };

            recognition.onerror = function(event) {
                console.error("Lỗi ghi âm:", event.error);
                resetRecordButton();
            };

            recognition.onend = resetRecordButton;

            recordBtn.addEventListener("click", function() {
                if (recordBtn.classList.contains("recording")) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });
        }

        function resetRecordButton() {
            recordBtn.textContent = "Bắt đầu ghi âm";
            recordBtn.classList.remove("recording");
        }

        submitBtn.addEventListener("click", function() {
            const age = document.getElementById("age").value;
            const sex = document.getElementById("sex").value;
            const symptoms = symptomsInput.value.trim();

            let hasError = false;
            if (!age || !symptoms) {
                alert("Vui lòng nhập đầy đủ thông tin.");
                return;
            } else if (age > 100) {
                alert("Độ tuổi không hợp lệ.");
                return;
            }

            handleSubmit(symptoms, age, sex);
        });

        function handleSubmit(symptoms, age, sex) {
            translateText(symptoms, "vi", "en") // Gọi hàm translateText
                .then(translatedSymptoms => fetchInfermedicaParse(translatedSymptoms, age))
                .then(data => fetchInfermedicaDiagnosis(data, age, sex))
                .then(data => displayDiagnosis(data))
                .catch(handleError);
        }

        // Hàm dịch triệu chứng từ tiếng Việt sang tiếng Anh
        function translateText(text, fromLang, toLang) {
            return fetch("https://api.mymemory.translated.net/get?q=" + encodeURIComponent(text) + "&langpair=" + fromLang +
                    "|" + toLang)
                .then(response => response.json())
                .then(data => data.responseData.translatedText)
                .catch(error => {
                    console.error("Lỗi dịch:", error);
                    throw error; // Đẩy lỗi ra để xử lý ở nơi khác
                });
        }

        function fetchInfermedicaParse(translatedSymptoms, age) {
            return fetch("https://api.infermedica.com/v3/parse", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "App-Id": "263de5b3",
                    "App-Key": "d725d6b43df5f3b2ffcebc23a7dd1923",
                },
                body: JSON.stringify({
                    text: translatedSymptoms,
                    age: {
                        value: parseInt(age)
                    },
                    language: "en",
                }),
            }).then(response => response.json());
        }

        function fetchInfermedicaDiagnosis(data, age, sex) {
            const evidence = data.mentions.map(mention => ({
                id: mention.id,
                choice_id: mention.choice_id
            }));

            return fetch("https://api.infermedica.com/v3/diagnosis", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "App-Id": "263de5b3",
                    "App-Key": "d725d6b43df5f3b2ffcebc23a7dd1923",
                },
                body: JSON.stringify({
                    age: {
                        value: parseInt(age),
                        modifier: sex === "female" ? "female" : "male"
                    },
                    evidence: evidence,
                    sex: sex === "female" ? "female" : "male",
                }),
            }).then(response => response.json());
        }

        function displayDiagnosis(data) {
            diagnosisBody.innerHTML = ""; // Xóa nội dung cũ
            diagnosisTable.style.display = "table"; // Hiện bảng

            if (data.conditions && data.conditions.length > 0) {
                const translationPromises = data.conditions.map(condition => translateText(condition.name, "en", "vi"));

                Promise.all(translationPromises)
                    .then(translatedNames => {
                        data.conditions.forEach((condition, index) => {
                            const row = document.createElement("tr");
                            row.innerHTML =
                                `<td>${translatedNames[index]}</td><td>${(condition.probability * 100).toFixed(2)}%</td>`;
                            diagnosisBody.appendChild(row);
                        });
                    });
            } else {
                diagnosisEl.textContent = "Không tìm thấy chẩn đoán nào.";
                diagnosisTable.style.display = "none"; // Ẩn bảng nếu không có kết quả
            }
        }

        function handleError(error) {
            console.error("Lỗi:", error);
            diagnosisEl.textContent = "Đã xảy ra lỗi, vui lòng thử lại.";
        }
    </script>

@endsection
