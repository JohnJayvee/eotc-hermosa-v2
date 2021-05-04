<!DOCTYPE html>
<html>
<head>
	<title>Business Cv</title>
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
<h2 class="text-center">Business CV</h2>

<h4>Registrant Details</h4>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="fs14">
	<thead align="left">
		<tr>
			<th>Full Name</th>
			<th>Email Address</th>
			<th>Contact Number</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{$business->owner->fullname}}</td>
			<td>{{$business->owner->email}}</td>
			<td>{{$business->owner->contact_number}}</td>
		</tr>
	</tbody>
</table>
<h4>Business Address Information</h4>
<p>Location : {{$business->location}}</p>
<h4>Business Information</h4>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="fs14">
  <tr align="left">
    <th>DTI/SEC/CDA registration No :</th>
    <td>{{$business->dti_sec_cda_registration_no}}</td>
  </tr>
  <tr align="left">
    <th>Capitalization :</th>
    <td>{{$business->capitalization}}</td>
  </tr>
  <tr align="left">
    <th>Dominant Name :</th>
    <td>{{$business->dominant_name}}</td>
  </tr>
  <tr align="left">
    <th>Business Name :</th>
    <td>{{$business->business_name}}</td>
  </tr>
  <tr align="left">
    <th>Website :</th>
    <td>{{$business->website_url}}</td>
  </tr>
  <tr align="left">
    <th>Mobile Number :</th>
    <td>{{$business->mobile_no}}</td>
  </tr>
  <tr align="left">
    <th>Telephone Number :</th>
    <td>{{$business->telephone_no}}</td>
  </tr>
  <tr align="left">
    <th>Email :</th>
    <td>{{$business->email}}</td>
  </tr>
  <tr align="left">
    <th>Business Type :</th>
    <td>{{str_replace("_"," ",$business->business_type)}}</td>
  </tr>
  <tr align="left">
    <th>Business Scope :</th>
    <td>{{str_replace("_"," ",$business->business_scope)}}</td>
  </tr>
  <tr align="left">
    <th>No. of Male Employee</th>
    <td>{{$business->no_of_male_employee}}</td>
  </tr>
  <tr align="left">
    <th>No. of Female Employee</th>
    <td>{{$business->no_of_female_employee}}</td>
  </tr>
  <tr align="left">
    <th>No. of Male Employees Residing In City</th>
    <td>{{$business->male_residing_in_city}}</td>
  </tr>
  <tr align="left">
    <th>No. of Female Employees Residing In City</th>
    <td>{{$business->female_residing_in_city}}</td>
  </tr>
</table>
<h4>OTHER INFORMATION FORM (GOVERNMENT OWNED OR CONTROLLED CORPORATIONS)</h4>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="fs14">
  <tr align="left">
    <th width="50%">SSS Number</th>
    <td>{{$business->sss_no ?: "-"}}</td>
  </tr>
  <tr align="left">
    <th>Philhealth Number</th>
    <td>{{$business->philhealth_no ?: "-"}}</td>
  </tr>
  <tr align="left">
    <th>TIN Number</th>
    <td>{{$business->tin_no ?: "-" }}</td>
  </tr>
  <tr align="left">
    <th>PAGIBIG Number</th>
    <td>{{$business->pagibig_no ?: "-"}}</td>
  </tr>
</table>
</body>
</html>