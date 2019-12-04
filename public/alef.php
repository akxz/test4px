<?php
header('Content-Type: text/html; charset=utf-8');

function getSum($size = 6)
{
    $max = $size - 1; // max key
    $out = [];
    $prepend = 0;
    $current = 1;
    $next = 1;
    $sum = 0;

    // Столбцы
    for ($x = 0; $x <= $max; $x++) {
        // Строки
        for ($y = 0; $y <= $max; $y++) {

            $current = $next;
            $out[$y][$x] = $current;
            $next = $current + $prepend;
            $prepend = $current;

            // Если это диагональ
            if (($y + $x) == $max) {
                // Нам нужна только диагональ "снизу-вверх"
                if (($y >= $x && $x <= $max/2) || ($y <= $x && $x >= $max/2)) {
                    // Считаем сумму
                    $sum += $out[$y][$x];
                }
            }
        }
    }

    // echo '<pre>'; print_r($out);
    echo $sum;
}

function alefProgrammer()
{
    $code = '->11гe+20∆∆A+4µcњil->5•Ћ®†Ѓ p+5f-7Ќ¬f pro+10g+1悦ra->58->44m+1*m+2a喜er!';
    echo decode($code);
}

function decode($code, $position = 0, $line = '')
{
    $letter = getSymbol($code, $position);

    if (empty($letter)) {
        return $line;
    }

    if ( ! in_array($letter, ['+', '-', '>'])) {
        $line .= $letter;

        if (($position + 1) >= mb_strlen($code)) {
            return $line;
        }

        return decode($code, ($position + 1), $line);
    }

    if ($letter == '-') {
        // Управляющий символ, узнаем какой именно
        $next_letter = getSymbol($code, ($position + 1));

        if ($next_letter == '>') {
            // special symbol ->
            // Переход к символу от начала строки
            // Аргумент
            $arg = getArgument($code, ($position + 2));

            // recursive function
            return decode($code, $arg, $line);
        }

        // Символ Возврата
        // Кол-во шагов
        $arg = getArgument($code, ($position + 1));
        $position = $position + strlen((string) $arg) - $arg;
        return decode($code, $position, $line);
    } elseif ($letter === '+') {
        // Переход вперед
        // Кол-во шагов
        $arg = getArgument($code, ($position + 1));
        $position = $position + strlen((string) $arg) + $arg + 1;
        return decode($code, $position, $line);
    }
}

function getArgument($str, $position)
{
    $return = '';
    $status = true;
    while ($status) {
        $letter = getSymbol($str, $position);

        if (is_numeric($letter)) {
            $return .= (string) $letter;
            $position++;
        } else {
            $status = false;
        }
    }

    return (is_numeric($return)) ? $return : '';
}

function getSymbol($str, $position)
{
    return mb_substr($str, $position, 1);
}

getSum();

alefProgrammer();
