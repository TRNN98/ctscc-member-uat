<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Policy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400;1,500&display=swap"
        rel="stylesheet">


    <style>
        body {
            font-family: 'Prompt', sans-serif !important;
        }

    </style>
</head>

<body style="background-color: #ebf3eb;">
    <div class="py-3 my-4 ">

        <div class="container ">
            <div class="row border p-3 rounded-2 bg-white shadow" style="word-break:break-word ;">
                <a href="/" target="_self" style="text-decoration: none; width:auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-reply-fill" viewBox="0 0 16 16">
                        <path
                            d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                    </svg>&nbsp;กลับหน้าหลัก
                </a>
                <?php

                echo html_entity_decode(htmlspecialchars($json->content));
                ?>
            </div>
        </div>




    </div>

</body>

</html>
