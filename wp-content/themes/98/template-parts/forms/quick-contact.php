<a id="quick-contact-form" class="pad-anchor"></a>
<form class="form leadform" enctype="multipart/form-data" method="post" action="#quick-contact-form" id="quickcontact">
<input type="hidden" name="formID" value="quickcontact" >
<div class="row">
    <div class="col-sm-6">
		<div class="form-group">
			<label>NAME*</label>
			<input name="fullname" type="text" class="form-control" value="" required>
		</div> 
        <div class="form-group">      
            <label>EMAIL ADDRESS*</label>
            <input name="youremail" type="email" class="form-control" value="" required>
        </div> 
        <div class="form-group"> 
            <label>PHONE*</label>
            <div class="phone-group">
            <input type="tel" name="phone1" class="form-control ph ph1" value="" maxlength="3" >
            <input type="tel" name="phone2" class="form-control ph ph2" value="" maxlength="3" >
            <input type="tel" name="phone3" class="form-control ph ph3" value="" maxlength="4" >
            </div>
        </div> 
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>MESSAGE</label>
            <textarea name="additionalinfo" rows="4" class="form-control"></textarea>
        </div>
        <div class="form-group">
			<input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
            <button type="submit" class="btn btn-danger btn-md pull-md-right" >SEND</button>
        </div>
    </div>
</div> 
</form>