// Nhập jQuery trước tiên
import $ from "jquery";

// Nhập FilePond
import * as FilePond from "filepond";

// Nhập plugin cho FilePond
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Đăng ký cho các plugin
FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginImagePreview);

// Đặt FilePond vào window để sử dụng toàn cục
window.FilePond = FilePond;

// Nhập summernote
import "summernote/dist/summernote-bs5.js"; 
// Đặt jQuery vào window để sử dụng toàn cục
window.$ = $;
window.jQuery = $;

import 'select2';
import 'select2/dist/css/select2.css';
