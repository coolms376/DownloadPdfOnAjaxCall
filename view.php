<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
        *{
            font-family: Poppins;
        }
        ul{
            list-style: none;
        }
        ul li{
            padding: 1em 0.5em;
            text-decoration: none; 
        }
        .hidden{
            display: none;
        }
        .show{
            display: block;
        }
    </style>
</head>
<body>

    <form action="one.php" method="post">
        <input type="email" name="email" id="">
        <button type="submit" value="KLog">Log</button>
    </form>


    <button id="display">Show result</button></br></br>
    <button id="download" class="hidden" onclick="downloadResultPDF(false)">Download</button>

    <ul id="list"></ul>

    <script src="jquery-3.3.1.min.js"></script>
    <script>

        var displaybtn = document.getElementById("display");
        var list = document.getElementById("list");

        function createListItem(data){
            let li  = document.createElement("li");
            li.innerText = data;
            document.getElementById("list").appendChild(li)
        }
        function showdownloadButton(){
            let downloadButton = document.getElementById("download");

            if(downloadButton.classList.contains("hidden")){
                downloadButton.classList.remove("hidden");
                downloadButton.classList.add("show");
            }
        }

        displaybtn.addEventListener("click",function(list) {

            fetch("https://appservice35596995.azurewebsites.net/api.php").then(data=>data.json()).then(data=>{
                 for (i=0;i<data.length;i++)
                    createListItem(data[i])
            });

            showdownloadButton();

            
            
        },false);


        function downloadResultPDF(){
                let listdata = document.getElementById("list").outerHTML;
                $.ajax({
                    type:'POST',
                    data:{"data":listdata},
                    url:'https://appservice35596995.azurewebsites.net/one.php',
                    xhrFields: {
                        responseType: 'blob' // to avoid binary data being mangled on charset conversion
                    },
                    success: function(blob, status, xhr) {


                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var filename = "";
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        }


                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(blob);
                        a.href = url;
                        a.download = filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);

                        

                    }
                });
        
                return false;
        };


        

        
    </script>
    
</body>
</html>
