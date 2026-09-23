<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

$result = null;
$error = null;

// =========================
// Clear History
// =========================

if (isset($_POST['clear_history'])) {
    $_SESSION['history'] = [];
}

// =========================
// Calculator
// =========================

if (isset($_POST['calculate'])) {

    $number1Input = trim($_POST['number1'] ?? '');
    $number2Input = trim($_POST['number2'] ?? '');
    $operator = $_POST['operator'] ?? '';

    if ($number1Input === '' || $number2Input === '') {

        $error = "Both numbers are required";

    } else {

        $number1 = (float) $number1Input;
        $number2 = (float) $number2Input;

        $allowedOperators = ['+', '-', '*', '/', '%'];

        if (!in_array($operator, $allowedOperators, true)) {

            $error = "Invalid operator";

        } elseif ($operator === '/' && $number2 == 0) {

            $error = "Cannot divide by zero";

        } elseif ($operator === '%' && $number2 == 0) {

            $error = "Cannot modulo by zero";

        } else {

            switch ($operator) {

                case '+':
                    $result = $number1 + $number2;
                    break;

                case '-':
                    $result = $number1 - $number2;
                    break;

                case '*':
                    $result = $number1 * $number2;
                    break;

                case '/':
                    $result = $number1 / $number2;
                    break;

                case '%':
                    $result = (int)$number1 % (int)$number2;
                    break;
            }

            $calculation = "$number1 $operator $number2 = $result";

            $_SESSION['history'][] = $calculation;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Calculator</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .calculator {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.10);
        }

        /* Header */

        .calculator-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .calculator-header h1 {
            margin: 0 0 10px;
            font-size: 38px;
        }

        .calculator-header p {
            margin: 0;
            color: #777;
            font-size: 20px;
        }

        /* Calculator Row */

        .calculator-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 90px minmax(0, 1fr);
            gap: 14px;
            width: 100%;
        }

        .calculator-row input,
        .calculator-row select {
            width: 100%;
            min-width: 0;
            height: 60px;
            padding: 0 16px;
            font-size: 20px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: white;
            outline: none;
        }

        .calculator-row input:focus,
        .calculator-row select:focus {
            border-color: #555;
        }

        /* Buttons */

        .actions {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 20px;
        }

        .actions form {
            margin: 0;
        }

        .actions button {
            height: 55px;
            padding: 0 22px;
            border: none;
            border-radius: 12px;
            background: #222;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .actions button:hover {
            opacity: 0.85;
        }

        .actions .clear-button {
            background: #e33434;
        }

        /* Result */

        .result {
            margin-top: 30px;
            padding: 18px 20px;
            background: #f1f3f5;
            border-radius: 12px;
            text-align: center;
        }

        .result h2 {
            margin: 0;
            font-size: 28px;
        }

        /* Error */

        .error {
            margin-top: 20px;
            padding: 15px;
            background: #ffe5e5;
            color: #c62828;
            border-radius: 10px;
            text-align: center;
            font-size: 18px;
        }

        /* History */

        .history {
            margin-top: 35px;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .history-header h2 {
            margin: 0;
            font-size: 28px;
        }

        .history-count {
            color: #777;
            font-size: 16px;
        }

        .history ul {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
        }

        .history li {
            padding: 16px;
            margin-bottom: 10px;
            background: #f5f5f5;
            border-radius: 10px;
            font-size: 18px;
        }

        /* Mobile */

        @media (max-width: 600px) {

            body {
                padding: 20px 10px;
            }

            .calculator {
                padding: 25px 20px;
            }

            .calculator-header h1 {
                font-size: 30px;
            }

            .calculator-row {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }
            .actions form {
                width: 100%;
            }

            .actions button {
                width: 100%;
            }
        }

    </style>

</head>

<body>

<div class="calculator">

    <div class="calculator-header">

        <h1>Smart Calculator</h1>

        <p>Simple • Fast • Powerful</p>

    </div>


<!-- Calculator Form -->

<form method="post">

    <div class="calculator-row">

        <input 
            type="number" 
            name="number1" 
            step="any"
            placeholder="First number"
        >

        <select name="operator">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
            <option value="%">%</option>
        </select>

        <input 
            type="number" 
            name="number2" 
            step="any"
            placeholder="Second number"
        >

    </div>

    <div class="actions">

        <button
            type="submit"
            name="calculate"
        >
            Calculate
        </button>

        <button
            type="reset"
        >
            Reset
        </button>

    </div>

</form>


<!-- Clear History -->

<form method="post">

    <div class="actions">

        <button
            type="submit"
            name="clear_history"
            class="clear-button"
        >
            Clear History
        </button>

    </div>

</form>


    <!-- Result -->

    <?php if ($result !== null): ?>

        <div class="result">

            <h2>
                Result: <?= htmlspecialchars((string)$result) ?>
            </h2>

        </div>

    <?php endif; ?>


    <!-- Error -->

    <?php if ($error !== null): ?>

        <div class="error">

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>


    <!-- History -->

    <?php if (!empty($_SESSION['history'])): ?>

        <div class="history">

            <div class="history-header">

                <h2>Calculation History</h2>

                <span class="history-count">

                    <?= count($_SESSION['history']) ?>

                    calculations

                </span>

            </div>


            <ul>

                <?php foreach ($_SESSION['history'] as $calculation): ?>

                    <li>
                        <?= htmlspecialchars($calculation) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>

</div>

</body>

</html>