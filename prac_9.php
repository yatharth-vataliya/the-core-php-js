<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prac 9</title>
    <style type="text/css" media="screen">
        .btn {
            padding: 2em;
            height: 20px;
            width: 20px;
            margin: 2em;
            border-radius: 20%;
        }
    </style>
</head>
<body>
<button type="button" id="generate">New</button>
<div id="render">
    <div style="background-color: black;width: 300px;padding: 1em;margin: 1em;float:left;" align="center">
        <button type="button" class="btn decrement">-</button>
        <span id="dynamic_0" style="color: white; padding: 1em;font-size: 1em;">0</span>
        <button type="button" class="btn increment">+</button>
    </div>
</div>

<div class="button_block"
     style="display:none; background-color: black;width: 300px;padding: 1em;margin: 1em;float:left;" align="center">
    <button type="button" class="btn decrement">-</button>
    <span id="dynamic_0" style="color: white; padding: 1em;font-size: 1em;">0</span>
    <button type="button" class="btn increment">+</button>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>

    $("#generate").click(function () {
        div_block = $(".button_block").clone();
        div_block.removeClass('button_block');
        div_block.css('display', 'block');
        child_btn = div_block.children('button');
        div_block.appendTo("#render");
    });

    $(document).on('click', '.decrement', function () {
        val = parseInt($(this).next('span').html());
        isNaN(val) ? val = 0 : "";
        --val;
        $(this).next('span').html(val);
    });

    $(document).on('click', '.increment', function () {
        val = parseInt($(this).prev('span').html());
        isNaN(val) ? val = 0 : "";
        ++val;
        $(this).prev('span').html(val);
    });

</script>
</body>
</html>