//发起请求
function upload(){
  //获得表单传过来的文件
  var form = new FormData(document.getElementById("form"));
  //获得选择的api
  var api = $("input[type='radio']:checked").val();
  $.ajax({
    url:"upload.php",
    type:"post",
    data:form,
    cache: false,
    processData: false,
    contentType: false,
    success:function(data){
      if (data.res == "400") {
        var imgfile = data.path;
        $.ajax({
          url:api + "?path=" + imgfile,
          type:"post",
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            if (data.code == "0") {
               $(".container .card .card-footer").css("display","block");
               $("#image_url").text(data.imgurl);
               $("#copy").html("<button type=\"button\" class=\"btn btn-secondary btn-sm\" style=\"margin:10px 10px;\">复制链接</button>");
            }else if (data.code == "1"){
              alert("上传到服务器失败了");
            }
            
          },
          error:function(data){
            alert("上传到"+api+"服务器失败了");
          },
          beforeSend:function(data){
            $(".container .card .card-footer").html("<div class=\"card-footer-left\">上传中...</div>");
          }
        })
      }else if (data.res == "403") {
        $("#upload-result").text("格式不对");
      }else if (data.res == "404") {
        $("#upload-result").text("上传错误");
      }
      
    },
    error:function(data){
      alert("上传到我的服务器失败");
    }
  })
}