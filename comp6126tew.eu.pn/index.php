<head>
		<meta charset="UTF-8">
		<!-- www.phpied.com/conditional-comments-block-downloads/ -->
		<!--[if IE]><![endif]-->
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<link rel="shortcut icon" href="/favicon.ico">	
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">	
		
		<link rel="stylesheet" href="css/style.css">
		
		<!-- for the less enabled mobile browsers like Opera mini 
		<link rel="stylesheet" media="handheld" href="css/handheld.css?v=1">
		-->		
		
		<!-- google fonts -->
		<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Pompiere' rel='stylesheet' type='text/css'>
		
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<!endif]--> 
		
		
		<script src="js/scripts.js" type="text/javascript" ></script>		
   <!--		<script src="js/fb_scripts.js" language="JavaScript" type="text/javascript" ></script> -->
		<!--  Crypto hash script -->
		<!-- <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script> -->
		
		
		<!-- Put all my onload calls here -->
		<script>
      function load() {
      	
        BuildSelect('ccidfk_treat','6126CostCat','cclabel','ccid');
        BuildSelect('tidfk_ect','6126Treatment','medproc','tid');
        BuildSelect('ecidfk_ect','6126EmpCat','label','ecid');
        BuildSelect('ecidfk_emp','6126EmpCat','label','ecid');        
        BuildSelect('typeidfk_room','6126Roomtype','description','typeid');    
        BuildSelect('eidfk_doc','6126Employee','name','eid');           
        BuildDocOffSelect('rnumfk_doc');
        BuildSelect('eidfk_pt','6126Employee','name','eid');    
        BuildSelect('tidfk_pt','6126Treatment','medproc','tid');   
        BuildPatient('pidfk_admit');
        BuildPatient('pidfk_pt');
        BuildSelect('eidfk_admit','6126Doctor NATURAL JOIN 6126Employee','name','eid'); 
        BuildPRoom('rnumfk_bed');
        BuildPatient('pidfk_bass');
        BuildBed('bidfk_bass');
        BuildPatient('pidfk_to');
        BuildSelect('eidfk_to','6126Doctor NATURAL JOIN 6126Employee','name','eid');   
        BuildSelect('tidfk_to','6126Treatment','medproc','tid');        
        BuildTablelist('tablelist');    
        BuildPatient('pidfk_dis');  
        BuildPatient('pidfk_bill');  
        BuildPatient('pidfk_patrep');    
        BuildSelect('eidfk_docrep','6126Doctor NATURAL JOIN 6126Employee','name','eid');          
      }
      window.onload = load;
   </script>

		<title> COMP 6126 Final Project </title>	
</head>	

<body>

<div class="maincolumn" id="insertcol">
		<h2>Insertion Commands</h2>
		
				<strong>Create new patient</strong><button class='toggle' onclick="ToggleDiv('Div_A',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_A" style="display:none;">
						<form id="PatientInForm">
						<span>First Name:</span><input type="text" name="fname" id="fname" accesskey="fname"><br>
						<span>Last Name:</span> <input type="text" name="lname" id="lname" accesskey="lname"><br>
						<span>Sex:</span> <input type="text" name="sex" id="sex" accesskey="sex"><br>
						<span>Phone:</span> <input type="text" name="phone" id="phone" accesskey="phone"><br>
						<span>Street:</span> <input type="text" name="street" id="street" accesskey="street"><br>
						<span>City:</span> <input type="text" name="city" id="city" accesskey="city"><br>
						<span>State:</span> <input type="text" name="state" id="state" accesskey="state"><br>
						<span>Zip:</span> <input type="text" name="zip" id="zip" accesskey="zip"><br>
						<span>Insurance Carrier:</span> <input type="text" name="inscarrier" id="inscarrier" accesskey="inscarrier"><br>
						<span>Insurance policy#:</span> <input type="text" name="policynum" id="policynum" accesskey="policynum">
						</form>
						<!-- <button onclick="PatientIn()">Insert</button> -->
						<button onclick="SQLInsert('PatientIn','6126Patient')">Insert</button>
						<button onclick="CleanDiv('PatientIn')">Clear</button>						
						<br>
						<div id="PatientIn"></div><br><br>
				</div>
		
		
				<strong>Create new treatment cost category</strong><button class='toggle' onclick="ToggleDiv('Div_B',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_B" style="display:none;">
						<form id="CostCatInForm">
						<span>Label:</span> <input onchange="BuildSelect('ccidfk_treat','6126CostCat','cclabel','ccid')" type="text" name="cclabel" id="cclabel" accesskey="cclabel"><br>
						<span>Fee:</span> <input type="text" name="ccfee" id="ccfee" accesskey="ccfee">
						</form>
						<button onclick="SQLInsert('CostCatIn','6126CostCat')">Insert</button>
						<button onclick="CleanDiv('CostCatIn')">Clear</button>						
						<br>
						<div id="CostCatIn"></div><br><br>
				</div>
				
				
				<strong>Create new employee cost category</strong><button class='toggle' onclick="ToggleDiv('Div_C',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_C" style="display:none;">
						<form id="EmpCatInForm">
						<span>Label:</span> <input type="text" name="eclabel" id="eclabel" accesskey="label"><br>
						<span>Fee:</span> <input type="text" name="ecfee" id="ecfee" accesskey="fee">
						</form>
						<button onclick="SQLInsert('EmpCatIn','6126EmpCat')">Insert</button>
						<button onclick="CleanDiv('EmpCatIn')">Clear</button>						
						<br>
						<div id="EmpCatIn"></div><br><br>
				</div>
				
				
				<strong>Create new treatment</strong><button class='toggle' onclick="ToggleDiv('Div_D',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_D" style="display:none;">
						<form id="TreatmentForm">
						<span>Description:</span> <input type="text" name="medproc" id="medproc" accesskey="medproc" title="Describe the procedure involved"><br>
						<span>Cost Category:</span> <select data-field="ccid" id="ccidfk_treat"></select>
						</form>
						<button onclick="SQLInsert('Treatment','6126Treatment')">Insert</button>
						<button onclick="CleanDiv('Treatment')">Clear</button>		
						<button onclick="load()">Update Select</button>					
						<br>
						<div id="Treatment"></div><br><br>
				</div>
				
				
				<strong>Associate Employee Category & Treatment</strong><button class='toggle' onclick="ToggleDiv('Div_E',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_E" style="display:none;">
						<form id="EmpCatTreatForm">
						<span>Treatment:</span> <select data-field="tid" id="tidfk_ect"></select><br>
						<span>Employee Category:</span> <select data-field="ecid" id="ecidfk_ect"></select>
						<span>How many:</span> <input type="text" name="ectqty" id="ectqty" accesskey="qty">
						</form>
						<button onclick="SQLInsert('EmpCatTreat','6126EmpCatTreat')">Insert</button>
						<button onclick="CleanDiv('EmpCatTreat')">Clear</button>	
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="EmpCatTreat"></div><br><br>
				</div>
				
				
				<strong>Create New Employee</strong><button class='toggle' onclick="ToggleDiv('Div_F',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_F" style="display:none;">
						<form id="EmployeeForm">
						<span>Employee Name:</span> <input type="text" name="empname" id="empname" accesskey="name" ><br>
						<span>Employee Category:</span> <select data-field="ecid" id="ecidfk_emp"></select>
						</form>
						<button onclick="SQLInsert('Employee','6126Employee')">Insert</button>
						<button onclick="CleanDiv('Employee')">Clear</button>
						<button onclick="load()">Update Select</button>					
						<br>
						<div id="Employee"></div><br><br>
				</div>
				
								
				<strong>Create New Roomtype</strong><button class='toggle' onclick="ToggleDiv('Div_G',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_G" style="display:none;">
						<form id="RoomtypeForm">
						<span>Room type description:</span> <input type="text" name="roomtypedesc" id="roomtypedescgg" accesskey="description" ><br>
						<span>Room rate:</span> <input type="text" name="roomrate" id="roomrate" accesskey="rate" ><br>						
						</form>
						<button onclick="SQLInsert('Roomtype','6126Roomtype')">Insert</button>
						<button onclick="CleanDiv('Roomtype')">Clear</button>				
						<br>
						<div id="Roomtype"></div><br><br>
				</div>
				
								
				<strong>Create New Room</strong><button class='toggle' onclick="ToggleDiv('Div_H',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_H" style="display:none;">
						<form id="RoomForm">
						<span>Room number:</span> <input type="text" name="rnum" id="rnum" accesskey="rnum" ><br>
						<span>Room type:</span> <select data-field="typeid" id="typeidfk_room"></select>
						</form>
						<button onclick="SQLInsert('Room','6126Room')">Insert</button>
						<button onclick="CleanDiv('Room')">Clear</button>	
						<button onclick="load()">Update Select</button>			
						<br>
						<div id="Room"></div><br><br>
				</div>
				
								
				<strong>Designate employee as Doctor</strong><button class='toggle' onclick="ToggleDiv('Div_I',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_I" style="display:none;">
						<form id="DoctorForm">
						<span>Employee:</span> <select data-field="eid" id="eidfk_doc"></select><br>
						<span>Phone:</span> <input type="text" name="docphone" id="docphone" accesskey="phone" ><br>
						<span>Room:</span> <select data-field="rnum" id="rnumfk_doc"></select>
						</form>
						<button onclick="SQLInsert('Doctor','6126Doctor')">Insert</button>
						<button onclick="CleanDiv('Doctor')">Clear</button>	
						<button onclick="load()">Update Select</button>			
						<br>
						<div id="Doctor"></div><br><br>				
				</div>
				
				
				<strong>Record patient treatment administration</strong><button class='toggle' onclick="ToggleDiv('Div_J',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_J" style="display:none;">
						<form id="PatientTreatForm">
						<span>Employee:</span> <select data-field="eid" id="eidfk_pt"></select><br>
						<span>Patient:</span> <select data-field="pid" id="pidfk_pt"></select><br>
					 	<span>Treatment:</span> <select data-field="tid" id="tidfk_pt"></select><br>
						<span>Hours:</span> <input type="text" name="admtreathours" id="admtreathours" accesskey="hours" ><br>
						</form>
						<button onclick="SQLInsert('PatientTreat','6126PatientTreat')">Insert</button>
						<button onclick="CleanDiv('PatientTreat')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="PatientTreat"></div><br><br>			
				</div>
				
				
				<strong>Admit Patient</strong><button class='toggle' onclick="ToggleDiv('Div_K',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_K" style="display:none;">
						<form id="AdmissionForm">
						<span>Attending Doctor:</span> <select data-field="eid" id="eidfk_admit"></select><br>
						<span>Patient:</span> <select data-field="pid" id="pidfk_admit"></select><br>
						<span>Date:</span> <input type="text" name="admitdate" id="admitdate" accesskey="begindate" value=" <?php echo date("Y-m-d");?> "><br>
						</form>
						<button onclick="SQLInsert('Admission','6126Admission')">Insert</button>
						<button onclick="CleanDiv('Admission')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="Admission"></div><br><br>							
				</div>
				
				<strong>Discharge Patient</strong><button class='toggle' onclick="ToggleDiv('Div_Y',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_Y" style="display:none;">
						<form id="DischargeForm">
						<span>Patient:</span> <select data-field="pid" id="pidfk_dis"></select><br>
						<span>Date:</span> <input type="text" name="dischargedate" id="dischargedate" accesskey="enddate" value=" <?php echo date("Y-m-d");?> "><br>
						</form>
						<button onclick="SQLDischarge()">Insert</button>
						<button onclick="CleanDiv('Discharge')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="Discharge"></div><br><br>							
				</div>
	
	
				<strong>Create new Bed</strong><button class='toggle' onclick="ToggleDiv('Div_L',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_L" style="display:none;">
						<form id="BedForm">
						<span>Room:</span> <select data-field="rnum" id="rnumfk_bed" onchange="BedLabel();"></select>
						<span>Label:</span> <select data-field="label" id="bedlabel"></select>
						</form>
						<button onclick="SQLInsert('Bed','6126Bed')">Insert</button>
						<button onclick="CleanDiv('Bed')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="Bed"></div><br><br>	
				</div>
				

				<strong>Assign Patient a bed</strong><button class='toggle' onclick="ToggleDiv('Div_M',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_M" style="display:none;">
						<form id="BedAssignmentForm">
						<span>Patient:</span> <select data-field="pid" id="pidfk_bass"></select><br>
						<span>Bed:</span> <select data-field="bid" id="bidfk_bass"></select>
						<span>Date:</span> <input type="text" name="bedstartdate" id="bedstartdate" accesskey="begindate" value=" <?php echo date("Y-m-d");?> "><br>
						</form>
						<button onclick="SQLInsert('BedAssignment','6126BedAssignment')">Insert</button>
						<button onclick="CleanDiv('BedAssignment')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="BedAssignment"></div><br><br>	
				</div>
				

				<strong>Doctor ordered treatment entry</strong><button class='toggle' onclick="ToggleDiv('Div_N',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_N" style="display:none;">
						<form id="TreatOrderForm">
						<span>Doctor:</span> <select data-field="eid" id="eidfk_to"></select><br>
						<span>Patient:</span> <select data-field="pid" id="pidfk_to"></select><br>
						<span>Treatment:</span> <select data-field="tid" id="tidfk_to"></select><br>
					 	<input type="hidden" name="totimestamp" id="totimestamp" accesskey="datetime" value=" <?php echo date("m-d-Y H:i:s");?> "><br>
						</form>
						<button onclick="SQLInsert('TreatOrder','6126TreatOrder')">Insert</button>
						<button onclick="CleanDiv('TreatOrder')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="TreatOrder"></div><br><br>						
				</div>		
						
						
						
								
</div>

<div class="maincolumn" style="width:auto;min-width:350px;"> 
		<h2>Selection Commands</h2>
		
				<strong>Get everything in the table</strong><button class='toggle' onclick="ToggleDiv('Div_Z',this)" style="float:right;" >Hide</button> <br> 
				<div id="Div_Z" style="display:block;">
						<form id="TreatmentForm">
						<span>Select table to query:</span> <select data-field="table" id="tablelist"></select><br>
						</form>
						<button onclick="SQLSelect('Tableselect','tablelist')">Select</button>
						<button onclick="CleanDiv('Tableselect')">Clear</button>		
						<button onclick="load()">Update Select</button>					
						<br>
						<div id="Tableselect"></div><br><br>
				</div>		
		
		
</div>

<div class="maincolumn" style="width:auto;min-width:350px;"> 
		<h2>Reports</h2>
		
				<strong>Display Patient Bill</strong><button class='toggle' onclick="ToggleDiv('Div_W',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_W" style="display:none;">
						<form id="ReportBillForm">
						<span>Patient:</span> <select data-field="pid" id="pidfk_bill"></select><br>
						</form>
						<button onclick="SQLBill()">Generate</button>
						<button onclick="CleanDiv('ReportBill')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="ReportBill"></div><br><br>							
				</div>		
				
				
				<strong>Room Utilization Report</strong><button class='toggle' onclick="ToggleDiv('Div_X',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_X" style="display:none;">
						<button onclick="SQLRoomUtil()">Generate</button>
						<button onclick="CleanDiv('RoomUtil')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="RoomUtil"></div><br><br>							
				</div>	
		
		
				<strong>Patient Report</strong><button class='toggle' onclick="ToggleDiv('Div_T',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_T" style="display:none;">
						<form id="PatientReportForm">
						<span>Patient:</span> <select data-field="pid" id="pidfk_patrep"></select><br>
						</form>
						<button onclick="SQLPatientRep()">Generate</button>
						<button onclick="CleanDiv('PatientReport')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="PatientReport"></div><br><br>							
				</div>		
				
				
				<strong>Physician Report</strong><button class='toggle' onclick="ToggleDiv('Div_S',this)" style="float:right;" >Show</button> <br> 
				<div id="Div_S" style="display:none;">
						<form id="DocReportForm">
						<span>Doctor:</span> <select data-field="eid" id="eidfk_docrep"></select><br>
						</form>
						<button onclick="SQLDocRep()">Generate</button>
						<button onclick="CleanDiv('DocReport')">Clear</button>
						<button onclick="load()">Update Select</button>				
						<br>
						<div id="DocReport"></div><br><br>							
				</div>			
		
</div>


</body>