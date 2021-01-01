<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Prac 19</title>
</head>
<body>

<div class="container-fluid">
    <div class="row p-2 m-2">
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-striped rounded">
                <thead>
                <tr>
                    <th class="text-right text-white bg-dark" colspan="4" rowspan="4" id="result_box">0</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td onclick="clearAll();">AC</td>
                    <td>&plusmn;</td>
                    <td>&percnt;</td>
                    <td>
                        <button type="button" onclick="preCalculate('divide')" class="btn btn-block btn-lg btn-warning">
                            &divide;
                        </button>
                    </td>
                </tr>
                <tr>
                    <td onclick="setNumber(this);">7</td>
                    <td onclick="setNumber(this);">8</td>
                    <td onclick="setNumber(this);">9</td>
                    <td>
                        <button type="button" onclick="preCalculate('multiply')"
                                class="btn btn-block btn-lg btn-warning">&Chi;
                        </button>
                    </td>
                </tr>
                <tr>
                    <td onclick="setNumber(this);">4</td>
                    <td onclick="setNumber(this);">5</td>
                    <td onclick="setNumber(this);">6</td>
                    <td>
                        <button type="button" onclick="preCalculate('minus')" class="btn btn-block btn-lg btn-warning">
                            &minus;
                        </button>
                    </td>
                </tr>
                <tr>
                    <td onclick="setNumber(this);">1</td>
                    <td onclick="setNumber(this);">2</td>
                    <td onclick="setNumber(this);">3</td>
                    <td>
                        <button type="button" onclick="preCalculate('plus')" class="btn btn-block btn-lg btn-warning">
                            +
                        </button>
                    </td>
                </tr>
                <tr>
                    <td onclick="setNumber(this);" colspan="2">0</td>
                    <td onclick="setDecimal(this);">.</td>
                    <td>
                        <button type="button" onclick="calculate()" class="btn btn-block btn-lg btn-warning">=</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var result_box = document.getElementById('result_box');
    var first = '';
    var second = '';
    var change = false;
    var formula = '';

    function setNumber(element) {
        if (change == false) {
            first += parseFloat(element.innerText);
            result_box.innerText = first;
        } else if (change == true) {
            second += parseFloat(element.innerText);
            result_box.innerText = second;
        }
    }

    function preCalculate(frm) {
        formula = frm;
        change = true;
    }

    function setDecimal(element) {
        if (change == false) {
            if(!result_box.innerText.includes('.')) {
                first += element.innerText;
                result_box.innerText = first;
            }
        } else if (change == true) {
            if(!result_box.innerText.includes('.')) {
                second += element.innerText;
                result_box.innerText = second;
            }
        }
    }

    function calculate() {
        result = null;
        f = parseFloat(first);
        s = parseFloat(second);
        switch (formula) {
            case 'divide':
                result = f / s;
                break;
            case 'multiply':
                result = f * s;
                break;
            case 'minus':
                result = f - s;
                break;
            case 'plus':
                result = f + s;
                break;
            default:
                console.log('Default sate');
                break;
        }
        result_box.innerText = result;
    }

    function clearAll() {
        result_box.innerText = 0;
        first = '';
        second = '';
        change = '';
        formula = '';
    }
</script>

</body>
</html>