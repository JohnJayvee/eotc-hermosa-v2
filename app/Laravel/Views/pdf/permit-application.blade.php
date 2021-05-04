<!DOCTYPE html>
<html>
<head>
	<title>Application Form</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		.text-uppercase{
			text-transform: uppercase;
		}
		.text-center{
			text-align: center;
		}
		.lh1{
			line-height: 2px;
		}
		.fs14{
			font-size: 14px;
		}
		.fs12{
			font-size: 12px;
		}
		.fs13{
			font-size: 13px;
		}
		.border{
			border: solid 1px #000;
		}
		.p-1{
			padding: .5em;
		}
		.pt-1{
			padding-top: .5em;
		}
	</style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" style="border-bottom: solid 1px #fff;">
	<tbody class="fs14 border">
		<tr>	
			<td width="20%" class="text-center" rowspan="3" style="padding: 2px;"><img src="{{ public_path('web/img/hermosa-seal.png') }}" width="60%"></td>
			<td width="60%" class="text-center">APPLICATION FORM FOR BUSINESS PERMIT</td>
		</tr>
		<tr>
			<td width="60%" class="text-center">TAX YEAR</td>		
		</tr>
		<tr>
			<td width="60%" class="text-center">CITY/MUNICIPALITY <b>HERMOSA</b> </td>		
		</tr>
		<tr>
			<td colspan="2" class="fs12 border" style="padding: 1em">INSTRUCTIONS:
				<br>1.Provide accurate Information and print legibly to avoid delays. Incomplete application form will be returned to the applicant
				<br>2.Ensure that all documents attached to this form (if any)are complete and properly filled out.
			</td>
		</tr>
		
	</tbody>
</table>
<table width="100%" border="1" cellpadding="2" cellspacing="0">
	<tbody class="fs14">
		<tr>
			<td colspan="3" class="p-1">I. Application Section</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left: 2em;">1. Basic Information</td>
		</tr>
		<tr>
			<td style="padding-left: 2em;" width="40%">
				<input type="checkbox" {{$application->type == "new" ? "checked" :" "}} style="margin-top: 6px;"> New
				<input type="checkbox" {{$application->type == "renew" ? "checked" :" "}} style="margin-top: 6px;padding-left: 3em"> Renewal
			</td>
			<td colspan="2">
				Mode of Payment:
				<input type="checkbox"  style="margin-top: 6px;padding-left: 5px;"> Annually 
				<input type="checkbox"  style="margin-top: 6px;padding-left: 5px;"> Semi-Annually
				<input type="checkbox"  style="margin-top: 6px;padding-left: 5px;"> Quarterly
			</td>
		</tr>
		<tr>
			<td class="p-1">Date of Application: {{Helper::date_only($application->created_at)}}</td>
			<td class="p-1" colspan="2">DTI/SEC/CDA Registraion No.: {{$business->dti_sec_cda_registration_no}}</td>
		</tr>
		<tr>
			<td class="p-1">TIN No.: {{$business->tin_no}}</td>
			<td class="p-1" colspan="2">DTI/SEC/CDA Date of Registraion: {{ Helper::date_only($business->dti_sec_cda_registration_date)}}</td>
		</tr>
		<tr>
			<td colspan="3">
				&nbsp; Type of Business:
				<input type="checkbox"  {{$business->business_type == "sole_proprietorship" ? "checked" : " "}} style="margin-top: 6px;padding-left: 3em;"> Single 
				<input type="checkbox"  {{$business->business_type == "partnership" ? "checked" : " "}} style="margin-top: 6px;padding-left: 3em;"> Partnership
				<input type="checkbox"  {{$business->business_type == "corporation" ? "checked" : " "}} style="margin-top: 6px;padding-left: 3em;"> Corporation
				<input type="checkbox"  {{$business->business_type == "cooperative" ? "checked" : " "}} style="margin-top: 6px;padding-left: 3em;"> Cooperative
			</td>
		</tr>
		<tr>
			<td colspan="3">
				&nbsp;Amendment Fr.
				<input type="checkbox" style="margin-top: 6px;padding-left: 3.9em;"> Single 
				<input type="checkbox" style="margin-top: 6px;padding-left: 3em;"> Partnership
				<input type="checkbox" style="margin-top: 6px;padding-left: 3em;"> Corporation
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left: 5.9em">
				To
				<input type="checkbox" style="margin-top: 6px;padding-left: 3.7em;"> Single 
				<input type="checkbox" style="margin-top: 6px;padding-left: 3em;"> Partnership
				<input type="checkbox" style="margin-top: 6px;padding-left: 3em;"> Corporation
			</td>
		</tr>
		<tr>
			<td colspan="3" class="fs13">
				Are you enjoying tax incentive from any Government Entity ?
			<input type="checkbox" style="margin-top: 6px;padding-left: 1em;" {{$business->tax_incentive != "no" ? "checked" : " "}}> Yes 
			<input type="checkbox" style="margin-top: 6px;padding-left: 1em;" {{$business->tax_incentive == "no" ? "checked" : " "}}> No
			<span style="padding-left: 1em">Please Specify: {{$business->tax_incentive != "no" ? $business->tax_incentive : " "}}</span>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="text-center p-1">Name of Taxpayer / Registrant</td>
		</tr>
		<tr>
			<td class="pt-1">Lastname: {{ Str::title($business->owner_lname) }}</td>
			<td class="pt-1">First Name: {{ Str::title($business->owner_fname) }}</td>
			<td class="pt-1">Middle Name: {{ Str::title($business->owner_mname) }} </td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Business Name: {{ Str::title($business->business_name) }}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Trade Name / Franchise: </td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left: 2em;">2. OTHER INFORMATION<br><span style="padding-left: 1em">Note:For Renewal applications , do not fill up this section unless certain information have changed</span></td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Business Address: {{ Str::title($business->location) }}</td>
		</tr>
		<tr>
			<td class="pt-1" >Postal Code: </td>
			<td class="pt-1" colspan="2">Email Address: {{ $business->email }}</td>
		</tr>
		<tr>
			<td class="pt-1" >Telephone No.: {{ $business->telephone_no }} </td>
			<td class="pt-1" colspan="2">Mobile No.: {{ $business->mobile_no }}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Owner's Address: {{ Str::title($business->owner_address) }}</td>
		</tr>
		<tr>
			<td class="pt-1" >Postal Code: </td>
			<td class="pt-1" colspan="2">Email Address: {{ strtolower($business->owner_email) }}</td>
		</tr>
		<tr>
			<td class="pt-1" >Telephone No.:  </td>
			<td class="pt-1" colspan="2">Mobile No.: {{ $business->owner_mobile_no }}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">In Case of emergency, provide name of contact person: {{ $business->emergency_contact_fullname }}</td>
		</tr>
		<tr>
			<td class="pt-1" >Telephone / Mobile No.: {{ $business->emergency_contact_tel_no }} {{$business->emergency_contact_tel_no && $business->emergency_contact_mobile_no ? "/" : " "}}  {{ $business->emergency_contact_mobile_no}} </td>
			<td class="pt-1" colspan="2">Email Address: {{$business->emergency_contact_email}} </td>
		</tr>
		<tr>
			<td class="pt-1">Business Area (in sq m): {{$business->business_area}}</td>
			<td class="pt-1">Total Number of Employees in Establishment: {{ $business->no_of_male_employee + $business->no_of_female_employee }}</td>
			<td class="pt-1">No. of Employees Residing within LGU: {{ $business->male_residing_in_city + $business->female_residing_in_city }} </td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Note: Fill Up Only if Business Place is Rented</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Lessor's Full Name: {{ Str::title($business->lessor_fullname) }}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Lessor's Full Address: {{ Str::title($business->lessor_address) }}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Lessor's Full Telephone / Mobile No.: {{ $business->lessor_tel_no }} {{$business->lessor_tel_no && $business->lessor_mobile_no ? "/" : " "}}  {{ $business->lessor_mobile_no}}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Lessor's Email Address: {{ Str::title($business->lessor_email) }}</td>
		</tr>
		<tr>
			<td class="pt-1" colspan="3">Monthly Rental: {{ Helper::money_format($business->lessor_monthly_rental) }}</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left: 2em;">2. BUSINESS ACTIVITY</td>
		</tr>
	</tbody>
</table>
<table width="100%" border="1" cellpadding="2" cellspacing="0">
	<thead class="fs12">
		<tr>
			<td rowspan="2">Line Of Business</td>
			<td rowspan="2">No. of Units</td>
			<td rowspan="2">Capitalization <br>(for New Business) </td>
			<td colspan="2">Gross/Sales Recipes (for Renewal) </td>
		</tr>
		<tr>
			<td>Essential</td>
			<td>Non-Essential</td>
		</tr>
	</thead>
	<tbody class="fs12">
		@forelse($activities as $activity)
			<tr>
				<td>{{ Str::title($activity->line_of_business) }}</td>
				<td>{{ $activity->no_of_unit }}</td>
				<td>{{ $activity->capitalization }}</td>
				<td></td>		
				<td></td>		
			</tr>	
		@empty
		@endforelse
	</tbody>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="padding-top: 3em">
	<tbody class="fs13">
		<tr>
			<td>I DECLARE UNDER OF PERJURY that the foregoing information are true based on my personal and authentic records.Further I agree to Comply with the regulatory requirement and other deficincies within 30 days from release of the business permit</td>
		</tr>
		<tr>
			<td align="right" style="padding-top: 2em;">_________________________________________________ <br><span style="padding-right: .5em">Signature of APPLICANT/TAXPAYER over Printed Name</span></td>

		</tr>
		<tr>
			<td align="right" style="padding-right: 4em;padding-top: 2em"> ____________________________ <br> <span style="padding-right: 5em;"> Position Title</span></td>
		</tr>
	</tbody>
</table>
<p class="fs13" style="padding-top: 2em;"></p>

<p class="fs13" style="padding-top: 5em; float: right;"></p>
<p class="fs13" style="padding-top: 5em; float: right;"></p>
</body>
</html>