        <h1>Montages photo</h1><br>

        <div class='containerWebcam'>

            <div class='webcamClass'>
                <div>
                    <video id='webcamId' class='videoClass' autoplay></video>
                    <img id='outputId' class='outputClass'>
                    <canvas class='canvas' id='canvas' width='480' height='360'></canvas>
                </div>
                <div>
                    <form method='post' action='index.php?control=image&action=uploadGallery' enctype='multipart/form-data'>
                        <input type='hidden' id='idImgUrl' name='img'/>
                        <button type='submit' id='takePhoto'>Prendre une photo</button>
                    </form>
                </div>
            </div>

            <div class='userImg'>
                <?php
                    authorImg();
                ?>
            </div>
        </div>
        <form method='post' id='formDel' action='index.php?control=image&action=delImage'>
            <input type='hidden' id='idDel' name='id'/>
        </form>

        <input type='file' accept='image/*' onchange='handleFiles(event)'><br>
        

        <script type='text/javascript'>
            var video = document.getElementById('webcamId');
            var uplImg = document.getElementById('outputId');
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
                navigator.mediaDevices.getUserMedia({video: true}).then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    video.style.display = 'inline-block';
                });
            }


            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');

            document.getElementById('takePhoto').addEventListener('click', function() {
                if (video.style.display === 'inline-block')
                    context.drawImage(video, 0, 0, 480, 360);
                else if (uplImg.style.display === 'inline-block')
                    context.drawImage(uplImg, 0, 0, 480, 360);
                else
                    return;
                var dataURL = canvas.toDataURL('image/jpg', 1);
                document.getElementById('idImgUrl').value = dataURL;
            });

            var delButtons = document.getElementsByClassName("delThumb");
            var i;
            for (i = 0; i < delButtons.length; i++) {
                delButtons[i].addEventListener('click', function(event) {
                    document.getElementById('idDel').value = event.currentTarget.id.substring(3, event.currentTarget.id.length);
                    document.getElementById('formDel').submit();
                });
            }

            function handleFiles(file) {

                var input = file.target;
                var reader = new FileReader();
                var video = document.getElementById('webcamId');
                reader.onload = function(){
                  var dataURL = reader.result;
                  var output = document.getElementById('outputId');
                  output.src = dataURL;
                  output.style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
                video.style.display = 'none';
            }
        </script>
