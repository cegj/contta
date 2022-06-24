<?php

include($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/get_days_in_month.php');

// Specific account
$account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);

// Specific category 
if (isset($_GET['mainCat']) && $_GET['mainCat'] === 'true'){
    $mainCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);
    $secCat = null;
} else {
    $secCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
    $mainCat = null;
}

// Specific month
if (isset($_GET['month'])){
    if ($_GET['month'] === 'current') {
        $month = $mes;
        $maxMonth = $mes;   
    } else {
        $month = $_GET['month'];
        $maxMonth = $_GET['month'];    
    }
} else {
    $month = 1;
    $maxMonth = 12;
}

// Specific year
if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = $ano;
}

// Specific day
$days = [];
if (isset($_GET['day'])){
    if ($_GET['day'] === 'all'){
        $daysInMonth = get_days_in_month($month, $year);
        for ($d = 1; $d <= $daysInMonth; $d++){
            array_push($days, $d);
        }
    } else {
        $days = [$_GET['day']];
    }
}

//Get data and send
$data = [];

for ($month; $month <= $maxMonth; $month++){

    $object = [];

    if ($mainCat){
        $category = $mainCat;
    } else {
        $category = $secCat;
    }

    if (sizeof($days) !== 0){

        foreach($days as $day){
            $ofDayIncomes = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, $day, false, "R"));
            $ofDayExpenses = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, $day, false, "D"));        
            $ofDayBalance = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, $day, false));
            $ofMonthIncomes = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, $day, true, "R"));
            $ofMonthExpenses = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, $day, true, "D"));        
            $ofMonthBalance = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, $day, true)); 
            $ofAllIncomes = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, $day, false, "R"));
            $ofAllExpenses = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, $day, false, "D"));        
            $ofAllBalance = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, $day, false));  


            $object = [
                'day' => intval($day),
                'month' => intval($month),
                'year' => intval($year),
                'account' => $account,
                'category' => $category,
                'ofday' => [
                    'incomes' => $ofDayIncomes,
                    'expenses' => $ofDayExpenses,
                    'balance' => $ofDayBalance    
                ],
                'ofmonth' => [
                    'incomes' => $ofMonthIncomes,
                    'expenses' => $ofMonthExpenses,
                    'balance' => $ofMonthBalance    
                ],
                'ofall' => [
                    'incomes' => $ofAllIncomes,
                    'expenses' => $ofAllExpenses,
                    'balance' => $ofAllBalance    
                ]
            ];
        
            array_push($data, $object);
        } 
    } else {

        $ofMonthIncomes = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, null, true, "R"));
        $ofMonthExpenses = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, null, true, "D"));        
        $ofMonthBalance = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, null, true)); 

        $ofAllIncomes = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, null, false, "R"));
        $ofAllExpenses = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, null, false, "D"));        
        $ofAllBalance = floatval(calculate_result($bdConexao, $month, $year, "SAM", $account, $secCat, $mainCat, null, false));

        $generalIncomes = floatval(calculate_result($bdConexao, $month, $year, "SAG", $account, $secCat, $mainCat, null, false, "R"));
        $generalExpenses = floatval(calculate_result($bdConexao, $month, $year, "SAG", $account, $secCat, $mainCat, null, false, "R"));
        $generalBalance = floatval(calculate_result($bdConexao, $month, $year, "SAG", $account, $secCat, $mainCat, null, false));
        

        // $incomes = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, null, true, "R"));
        // $expenses = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, null, true, "D"));    
        // $balance = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, null, true));    
    
        $object = [
            'month' => intval($month),
            'year' => intval($year),
            'account' => $account,
            'category' => $category,
            'ofmonth' => [
                'incomes' => $ofMonthIncomes,
                'expenses' => $ofMonthExpenses,
                'balance' => $ofMonthBalance    
            ],
            'ofall' => [
                'incomes' => $ofAllIncomes,
                'expenses' => $ofAllExpenses,
                'balance' => $ofAllBalance    
            ],
            'general' => [
                'incomes' => $generalIncomes,
                'expenses' => $generalExpenses,
                'balance' => $generalBalance    
            ]
            ];
    
        array_push($data, $object);
    
    }

}

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;