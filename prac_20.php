<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <title>Prac 20</title>
</head>
<body>

<div class="p-2 custom-counter rounded shadow-lg" style="display: none;position: absolute !important;">
    <button class="m-1 btn btn-danger decrement">-</button>
    <span class="m-2 widget_value"></span>
    <button class="m-1 btn btn-success increment">+</button>
</div>

<div class="p-3">
    <input type="text" id="custom1">
    <input type="text" id="custom2">
    <input type="text" id="custom3">
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function () {
        $.widget("custom.CustomCounter",
            {
                options: {
                    d_value: 0
                },
                _create: function () {
                    if ($(this.element).val() <= 0 || isNaN((this.element).val())) {
                        $(this.element).val(this.options.d_value);
                    }
                    this._on(this.element, {
                        "focus": function (event) {
                            var input_coordinates = $(event.target).offset();
                            var target_height = ($(event.target).height() + 8);
                            this._bindListeners();
                            $(".custom-counter").css({
                                'top': (input_coordinates.top + target_height) + 'px',
                                'left': (input_coordinates.left) + 'px'
                            });
                            $(".custom-counter").fadeIn();
                            $(".widget_value").html(this.options.d_value);
                        },
                        "input": function(event){
                            this.options.d_value = $(this.element).val();
                            $(".widget_value").html(this.options.d_value);
                        }
                    });
                    $(document).on("mousedown", function (event) {
                        var $target = $(event.target);
                        if (!$target.closest(".custom-counter").length && !$target.hasClass("custom-counter")) {
                            $(".custom-counter").fadeOut();
                        }
                    });
                },
                _bindListeners: function () {
                    $(".custom-counter").remove();
                    $("body").append(`
                        <div class="p-2 custom-counter rounded shadow-lg" style="display: none;position: absolute !important;">
    <button class="m-1 btn btn-danger decrement">-</button>
    <span class="m-2 widget_value"></span>
    <button class="m-1 btn btn-success increment">+</button>
</div>
                    `);
                    var self = this;

                    $(".decrement").on('click', function () {
                        --self.options.d_value;
                        $(self.element).val(self.options.d_value);
                        $(".widget_value").html(self.options.d_value);
                    });
                    $(".increment").on('click', function () {
                        ++self.options.d_value;
                        $(self.element).val(self.options.d_value);
                        $(".widget_value").html(self.options.d_value);
                    });
                }
            });
    });

    $(document).ready(function () {
        $("#custom1").CustomCounter();
        $("#custom2").CustomCounter();
        $("#custom3").CustomCounter();
    });


</script>

</body>
</html>