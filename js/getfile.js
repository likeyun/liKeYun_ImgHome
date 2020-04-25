// 轮询文件名
function lunxun() {
    setInterval("getfilename()",1000);
}

//获取文件名
function getfilename() {
    var file_name = $(".container .card .card-body .file_btn").val();
    var filename = file_name.match(/th\\(\S*)/)[1];
    $(".container .card .card-body .file-name").text(filename);
    if (filename) {
      $(".container .card .card-body .upload-file").html("<input type=\"button\" class=\"btn btn-outline-secondary\" onclick=\"upload()\" id=\"file_upload_btn\" value=\"上传\"/>");
    }else{
      //
    }
}