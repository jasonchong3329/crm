<?php
    include_once 'connect.php';
    include_once 'system.php';
    include_once 'include_function.php';
    include_once 'class/Servicesorder.php'; 
    include_once 'class/SavehandlerApi.php';klhlkhlkhklkhkllkhkl
    include_once 'class/GeneralFunction.php';
    $o = new Servicesorder();
    $s = new SavehandlerApi();
    $gf = new GeneralFunction();
//
    $o->save = $s;
    $o->document_type = 'SI';
    $o->document_name = 'Services Invoice Management';
    $o->document_code = 'Services Invoice';
    $o->document_url = 'sinvoice.php';
    $o->menu_id = 45;

    $action = escape($_REQUEST['action']);
    $o->sorder_id = escape($_REQUEST['sorder_id']);
    $o->sorder_no = escape($_POST['sorder_no']);
    $o->sorder_customer = escape($_POST['sorder_customer']);
    $o->sorder_date = escape($_POST['sorder_date']);
    $o->sorder_machine_no = escape($_POST['sorder_machine_no']);
    $o->sorder_enginit = escape($_POST['sorder_enginit']);
    $o->sorder_country = escape($_POST['sorder_country']);
    $o->sorder_workkind = escape($_POST['sorder_workkind']);
    $o->sorder_groupcomp = escape($_POST['sorder_groupcomp']);
    $o->sorder_offerorder = escape($_POST['sorder_offerorder']);
    $o->sorder_prodgrp = escape($_POST['sorder_prodgrp']);
    $o->sorder_complstatus = escape($_POST['sorder_complstatus']);
    $o->sorder_branchoff = escape($_POST['sorder_branchoff']);
    $o->sorder_charging = escape($_POST['sorder_charging']);
    $o->sorder_status = escape($_POST['sorder_status']);

    $o->timesheet_id = escape($_REQUEST['timesheet_id']);
    $o->sorder_eststartdate = escape($_POST['sorder_eststartdate']);
    $o->sorder_estduration = escape($_POST['sorder_estduration']);
    $o->sorder_engineers = escape($_POST['sorder_engineers']);
    $o->sorder_paymentterm = escape($_POST['sorder_paymentterm']);
    $o->sorder_availability_enginer = escape($_POST['sorder_availability_enginer']);
    $o->sorder_completion_date = escape($_POST['sorder_completion_date']);
    $o->sorder_serfees = escape($_POST['sorder_serfees']);
    $o->sorder_serfees_desc = escape($_POST['sorder_serfees_desc']);
    $o->sorder_attentionto = escape($_POST['sorder_attentionto']);
    $o->sorder_workcontent = escape($_POST['sorder_workcontent']);
    $o->sorder_crmno = escape($_POST['sorder_crmno']);
    $o->sorder_offerinvoice = escape($_POST['sorder_offerinvoice']);
       
    $o->generate_document_type = escape($_POST['generate_document_type']);
    $o->sorder_workperformed = escape($_POST['sorder_workperformed']);
    $o->sorder_billaddress = escape($_POST['sorder_billaddress']);
    
    switch ($action) {
        case "create":
            if($o->create()){
                $_SESSION['status_alert'] = 'alert-success';
                $_SESSION['status_msg'] = "Create success.";
                rediectUrl("$o->document_url?action=edit&sorder_id=$o->sorder_id",getSystemMsg(1,'Create data successfully'));
            }else{
                $_SESSION['status_alert'] = 'alert-error';
                $_SESSION['status_msg'] = "Create fail.";
                rediectUrl("$o->document_url",getSystemMsg(0,'Create data fail'));
            }
            exit();
            break;
        case "update":
            if($o->update()){
                $_SESSION['status_alert'] = 'alert-success';
                $_SESSION['status_msg'] = "Update success.";
                rediectUrl("$o->document_url?action=edit&sorder_id=$o->sorder_id",getSystemMsg(1,'Update data successfully'));
            }else{
                $_SESSION['status_alert'] = 'alert-error';
                $_SESSION['status_msg'] = "Update fail.";
                rediectUrl("$o->document_url?action=edit&sorder_id=$o->sorder_id",getSystemMsg(0,'Update data fail'));
            }
            exit();
            break;  
        case "edit":
            if($o->fetchServicesOrderDetail(" AND s.sorder_id = '$o->sorder_id'","","",1)){
                $o->getInputForm("update");
            }else{
               rediectUrl("$o->document_url",getSystemMsg(0,'Fetch Data'));
            }
            exit();
            break;  
        case "delete":
            if($o->delete()){
                $_SESSION['status_alert'] = 'alert-success';
                $_SESSION['status_msg'] = "Delete success.";
                rediectUrl("$o->document_url",getSystemMsg(1,'Delete data successfully'));
            }else{
                $_SESSION['status_alert'] = 'alert-error';
                $_SESSION['status_msg'] = "Delete fail.";
                rediectUrl("$o->document_url",getSystemMsg(0,'Delete data fail'));
            }
            exit();
            break;   
        case "createForm":
            $o->getInputForm('create');
            exit();
            break;   
        case "validate_sorder":
            $t = $gf->checkDuplicate("db_sorder",'sorder_no',$o->sorder_no,'sorder_id',$o->sorder_id);
            if($t > 0){
                echo "false";
            }else{
                echo "true";
            }
            exit();
            break;  
        case "getDataTable":
            $o->getDataTable();
            exit();
            break;
        case "getServicesOrderDetail":
            $r = $o->getServicesOrderDetailTransaction();

            echo json_encode(array('sorder_barcode'=>$r['sorder_barcode'],'sorder_desc'=>$r['sorder_desc'],
                                   'sorder_sales_price'=>$r['sorder_sales_price'],'sorder_cost_price'=>$r['sorder_cost_price']));
            exit();
            break;
        default: 
            $o->getListing();
            exit();
            break;
    }


