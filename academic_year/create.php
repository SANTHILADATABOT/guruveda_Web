<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>Accounting Year<small> Create</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">Accounting Year Add</li></ol>	
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=academic_year/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form name="academic_year_form" id="academic_year_form">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="company" class="form-control-label">From Accounting Year <span class="star">*</span></label>
                                    <input type="text" class="form-control numeric" name="from_academic" id="from_academic" onkeypress="return numbersOnly(this, event);"  maxlength="4" onkeyup="get_academic_year(this.value),get_year()"><div id="from_academic_year_div" style="color:#F00;"></div>
                                </div>
                            </div>
                        
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="company" class="form-control-label">To Accounting Year <span class="star">*</span></label>
                                    <input type="text" class="form-control numeric" name="to_academic" id="to_academic" onkeypress="return numbersOnly(this, event);"  maxlength="4" onkeyup="enterevent(event,'button','to_academic')" readonly>
                                </div>
                            </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-sm" onClick="add_academicyear(from_academic.value,to_academic.value)"><i class="fa fa-dot-circle-o"></i> Submit</button>
                            <a href="index1.php?filename=academic_year/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                        </div>
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

