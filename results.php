<?php
include("functions.php");

# Get form data
$name = $_POST['name'];
$age = $_POST['age'];
$item_amount = convert_to_int($_POST['itemAmount']);

$total_income = convert_to_int($_POST['totalIncome']);
$total_expenses =  convert_to_int($_POST['totalExpenses']);
$net_income =  convert_to_int($_POST['totalNetIncome']);
$total_debt =  convert_to_int($_POST['totalDebt']);
$cc_interest = substr(($_POST['ccInterest']),0 , strlen($_POST['ccInterest']) ) / 100;
$cc_min_payment =  convert_to_int($_POST['minPayment']);
$savings_balance = convert_to_int($_POST['totalSavings']);
$saving_interest = substr($_POST['totalSavingsInterest'], 0 , strlen($_POST['totalSavingsInterest']))/100;
$checking_balance = convert_to_int($_POST['totalCheckings']);
$loan_interest = substr($_POST['loanInterest'], 0 , strlen($_POST['loanInterest']))/100;
$loan_months = $_POST['loanMonths'];

# Calculations
$cc_info = config_montly_payment($cc_min_payment, $item_amount, $cc_interest, 30, 365);
$total_savings = get_total_savings($savings_balance,$saving_interest, 730,365);
$total_savings_with = get_total_savings(($savings_balance -$item_amount),$saving_interest, 730,365);
$loan_info = get_loan_data($item_amount, $loan_interest, $loan_months);
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Should I Buy It?</title>
<link href="assets/style.css" rel="stylesheet" type="text/css">
<link href="assets/style.css" rel="stylesheet" type="text/css">
<script src="assets/jquery-1.11.1.min.js"></script>
<script>
$(document).ready(function(){
  
    $('input[type="text"]').each(function(){
		value = $(this).val();
		
		if ($(this).val().indexOf('-') == 1)
		{
			newValue = $(this).val().replace('-','');
			$(this).val('-' + newValue);
			$(this).css('color','red');
		
		}
		});
		
});
</script>
</head>

<body>

  <div id="wrapper">
    <p>&nbsp;</p>
    <div id="box-content">
      <div class="box-content-heading-title">
        <p>Results</p>
      </div>
      <div class="box-content-section">
        <div class="box-content-heading-sub-main">
          <p>Overview</p>
        </div>
                <div class="box-content-left">
          <p>Item Amount: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="ammount" type="text" id="income" value="<?php echo $_POST['itemAmount']; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Current Annual Income: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="income" type="text" id="income" value="<?php echo $_POST['totalNetIncome']; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Current Annual Expenses: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="expenses" type="text" id="expenses" value="<?php echo "$" .($total_expenses *12); ?>" readonly>
          </p>
        </div>
                <div class="box-content-left">
          <p>Current Net Gain/Loss: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="expenses" type="text" id="expenses" value="<?php echo "$" .($net_income - ($total_expenses *12)); ?>" readonly>
          </p>
        </div>
      </div>
      <div class="box-content-space">
        <p>&nbsp;</p>
      </div>
      <div class="box-content-section">
        <div class="box-content-heading-sub-main">
          <p>If Financed with a Credit Card</p>
        </div>
        <div class="box-content-left">
          <p>Amount Financed: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="income" type="text" id="income" value="<?php echo $_POST['itemAmount']; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Interest Rate: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="expenses" type="text" id="expenses" value="<?php echo $_POST['ccInterest'] ; ?>" readonly>
          </p>
        </div>
                <div class="box-content-left">
          <p>Monthly Payment Toward Balance: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="debt" type="text" id="age" value="<?php echo $_POST['minPayment'] ; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Total Months: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="debt" type="text" id="age" value="<?php echo $cc_info['total_months']; ?>" readonly>
          </p>
        </div>
         <div class="box-content-left">
          <p>Total Interest Paid: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="debt" type="text" id="age" value="<?php echo "$" . $cc_info['total_interest']; ?>" readonly>
          </p>
        </div>       
        <div class="box-content-left">
          <p>Total Interest cost and amount: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="debt" type="text" id="age" value="<?php echo "$" . round($cc_info['total_interest'] + $item_amount); ?>" readonly>
          </p>
        </div>       
      </div>
      <div class="box-content-section">
        <div class="box-content-heading-sub-main">
          <p>If Financed with a Loan</p>
        </div>
        <div class="box-content-left">
          <p>Amount Financed </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="expenses" type="text" id="expenses" value="<?php echo  $_POST['itemAmount']  ; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Interest Rate: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="income" type="text" id="income" 
            value="<?php echo $_POST['loanInterest']; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Number Of Months:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="loanMonths" 
            value="<?php echo $_POST['loanMonths']; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Monthly Payment:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="savingstotal" value="<?php echo "$" . round($loan_info['montly_payment']) ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Total Interest Paid:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="savingstotal" value="<?php echo "$" . round($loan_info['total_interest']) ?>" readonly>
          </p>
        </div>
        <div class="box-content-space">
        <p>&nbsp;</p>
      </div>
      
      </div>
      <div class="box-content-space">
        <p>&nbsp;</p>
      </div>
      
      <div class="box-content-section">
        <div class="box-content-heading-sub-main">
          <p> If Withdrawn from Savings</p>
        </div>
        <div class="box-content-left">
          <p>Interest Rate: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="expenses" type="text" id="expenses" value="<?php echo $_POST['totalSavingsInterest'] ; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Amount in Savings: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="income" type="text" id="income" value="<?php echo $_POST['totalSavings']; ?>" readonly>
          </p>
        </div>
               <div class="box-content-left">
          <p>If Amount not Withdrawn:&nbsp;</p>
        </div>
        <div class="box-content-right">
          <p>&nbsp;
           
          </p>
        </div>
        <div class="box-content-left">
          <p>Balance after two years:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="savingstotal" value="<?php echo "$" . round($total_savings); ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Interest Accumulated:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="savingstotal" value="<?php echo "$" . round($total_savings - $savings_balance); ?>" readonly>
          </p>
        </div>
       <div class="box-content-left">
          <p>If Amount Withdrawn:&nbsp;</p>
        </div>
        <div class="box-content-right">
          <p>&nbsp;
           
          </p>
        </div>
        
                        <div class="box-content-left">
          <p>New Balance:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings" type="text" id="savingstotal" value="<?php echo "$" . ($savings_balance - $item_amount); ?>" readonly>
          </p>
        </div>
                
        <div class="box-content-left">
          <p>Balance after two years:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrs" type="text" id="age" value="<?php echo "$" . round($total_savings_with); ?>" readonly>
          </p>
        </div>
          <div class="box-content-left">
          <p>Interest Accumulated:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="savingstotal" value="<?php echo "$" . round($total_savings_with - ($savings_balance - $item_amount)); ?>" readonly>
          </p>
        </div>
        <div class="box-content-space">

        </div>
        <div class="box-content-space">
        <p>&nbsp;</p>
      </div>
      </div>
            <div class="box-content-space">
        <p>&nbsp;</p>
      </div>
        <div class="box-content-section">
        <div class="box-content-heading-sub-main">
          <p> If Withdrawn from Checking</p>
        </div>
        <div class="box-content-left">
          <p>Item Amount: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="expenses" type="text" id="expenses" value="<?php echo  $_POST['itemAmount']  ; ?>" readonly>
          </p>
        </div>
        <div class="box-content-left">
          <p>Checking: </p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="income" type="text" id="income" value="<?php echo $_POST['totalCheckings']; ?>" readonly>
          </p>
        </div>
               <div class="box-content-left">
          <p>If Amount  Withdrawn:&nbsp;</p>
        </div>
        <div class="box-content-right">
          <p>&nbsp;
           
          </p>
        </div>
        <div class="box-content-left">
          <p>Checking:</p>
        </div>
        <div class="box-content-right">
          <p>
            <input name="totalSavings2yrsnon" type="text" id="savingstotal" value="<?php echo "$" . round($checking_balance - $item_amount); ?>" readonly>
          </p>
        </div>
        <div class="box-content-space">
        <p>&nbsp;</p>
      </div>
      
      </div>
    </div>
          <p>&nbsp;</p>

      </div>
      
      
</body>
</html>