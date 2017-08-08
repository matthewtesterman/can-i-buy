<?php
# functions.php - Lists functions to be used with results.php to help calculate financial information.
# Created by Matthew Testerman
# December 1, 2014

//$interest_ammount = get_cc_interest_amount(1000,.087,30,365);
//config_montly_payment(1000, 30);
//echo "Total interest payment: $interest_ammount";

# Convert string to an int.
function convert_to_int($string)
{
	$string = substr($string, 1);
	$string = intval($string);
	return $string;
}

# Get total interest on a credit card balance.
function get_cc_interest_amount($principle, $interest, $days, $compunded)
{
	$total_ammount = $principle * (pow((1 + ($interest/$compunded)) , $days));
	return round($total_ammount - $principle);
}

# Config a minimum payment and retrieve it.
function config_montly_payment($minimum_payment, $balance, $interest, $days, $compunded)
{
	$total_interest = 0;
	$total_months = 0;
	
	# While the balance is still owed (greater than 0)
	while ($balance > 0)
	{
		$total_months += 1;
		$old_balance = $balance;
		$interest_amount = get_cc_interest_amount($balance, $interest, $days, $compunded);
		if ($minimum_payment >= $balance)
		{
			$total_pay = $balance + $interest;
		}
		else
		{
			$total_pay = $minimum_payment + $interest_amount;
		}
		
		$total_interest += $interest_amount;
		
		$balance = $balance - $minimum_payment;
		
		//echo $old_balance .  "&nbsp;&nbsp;&nbsp;" . $total_pay . "<br />";
	}
		$payment_info['total_interest'] = $total_interest;
		$payment_info['total_months'] = $total_months;
		return $payment_info;
}

# Savings Calculation
function get_total_savings($acct_balance, $interest, $days, $compunded)
{
	$total_ammount = $acct_balance * (pow((1 + ($interest/$compunded)) , $days));
	return round($total_ammount, 2 );
}

# Calulate Loan information
function get_loan_data($principle, $loan_interest, $loan_months)
{
	$amount_after_time = $principle * (pow(1 + ($loan_interest/12), $loan_months));
	
	$loan['montly_payment'] = $amount_after_time / $loan_months;
	$loan['total_amount'] = $amount_after_time;
	$loan['total_interest'] = $amount_after_time - $principle;
	return $loan;
}
?>