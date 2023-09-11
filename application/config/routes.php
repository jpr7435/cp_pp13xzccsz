<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/






$route['admin/dropcampo'] = 'Operativo/dropcampo';
$route['admin/saveoptions'] = 'Operativo/saveoptions';
$route['admin/savefielddinamic'] = 'Operativo/savefielddinamic';

$route['admin/camposdinamicos'] = 'Operativo/camposdinamicos';



$route['sms/sendwhatsapp'] = 'Sms/sendwhatsapp';
$route['sms/saverespuesta'] = 'Sms/saverespuesta';
$route['sms/uploadsms'] = 'Sms/uploadsms';
$route['smsenvio/(:any)'] = 'Sms/envio/$1';
$route['sms/savemsg'] = 'Sms/savemsg';
$route['smsentrada'] = 'Sms/smsentrada';
$route['smsdetallecampana/(:any)'] = 'Sms/detallecampana/$1';
$route['sms/savecampana'] = 'Sms/savecampana';
$route['sms/createcampana'] = 'Sms/createcampana';
$route['sms/campana'] = 'Sms/campanas';
$route['sms/mensaje'] = 'Sms/mensajes';
$route['sms/respuestas'] = 'Sms/respuestas';
$route['operativo/uploadPredictivo'] = 'Operativo/uploadPredictivo';
$route['operativo/fechaPredictivo'] = 'Operativo/cargaPredictivo';

$route['prememo/(:any)'] = 'Operativo/prememo/$1';
$route['armarmemo'] = 'Operativo/armamemo';



$route['smshora'] = 'Cron/smsHora';
$route['createsmsadmin'] = 'Operativo/createsmsadmin';
$route['previewsmsadmin'] = 'Operativo/previewsmsadmin';
$route['savecriteriotareasadminsms'] = 'Operativo/savecriteriotareasadminsms';
$route['editarsmsadmin/(:any)'] = 'Operativo/editarsmsadmin/$1';
$route['savesmsadmin'] = 'Operativo/savesmsadmin';
$route['agregarsmsadmin'] = 'Operativo/agregarsmsadmin';
$route['sms/admin/(:any)'] = 'Operativo/smsadmin/$1';



$route['herramientas/sms2'] = 'Herramientas/sms2';
$route['herramientas/mail'] = 'Herramientas/mail';
$route['herramientas/avirtual'] = 'Herramientas/avirtual';


$route['cron/mejorgestion'] = 'Cron/mejorgestion';
$route['cron/mejorgestion180'] = 'Cron/mejorgestion180';
$route['cron/setintensidad'] = 'Cron/setintensidad';

$route['cron/mailaprobacion'] = 'Cron/mailaprobacion';
$route['cron/mailespecial'] = 'Cron/mailespecial';
$route['uploadPredictivo'] = 'Cron/uploadPredictivo';




$route['genera-informe'] = 'Generainforme/generaInforme';

$route['error-permisos'] = 'Users/errorpermisos';
$route['edit-user/(:any)'] = 'Users/editarusuario/$1';
$route['saveuser'] = 'Users/saveuser';
$route['add-user'] = 'Users/adduser';
$route['user-list'] = 'Users/listado';
$route['unlock-user/(:any)'] = 'Users/unlock/$1';



$route['dashboard/blocks/rightbar/chat.html'] = 'Main/chat';
$route['dashboard/blocks/rightbar/notifications.html'] = 'Main/notifications';
$route['dashboard/blocks/rightbar/activities.html'] = 'Main/activities';
$route['dashboard/blocks/rightbar/cart.html'] = 'Main/cart';
$route['dashboard/blocks/rightbar/settings.html'] = 'Main/settings';
$route['dashboard/blocks/rightbar/rightbar.html'] = 'Main/rightbar';
$route['dashboard/blocks/navbar/user-dropdown.html'] = 'Main/userdropdown';
$route['dashboard/blocks/navbar/apps-dropdown.html'] = 'Main/appsdropdown';
$route['dashboard/blocks/menus/material-sidebar.html'] = 'Main/materialsidebar';
$route['dashboard/blocks/sidebar-user-profile.html'] = 'Main/sidebaruserprofile';

$route['blocks/rightbar/chat.html'] = 'Main/chat';
$route['blocks/rightbar/notifications.html'] = 'Main/notifications';
$route['blocks/rightbar/activities.html'] = 'Main/activities';
$route['blocks/rightbar/cart.html'] = 'Main/cart';
$route['blocks/rightbar/settings.html'] = 'Main/settings';
$route['blocks/rightbar/rightbar.html'] = 'Main/rightbar';
$route['blocks/navbar/user-dropdown.html'] = 'Main/userdropdown';
$route['blocks/navbar/apps-dropdown.html'] = 'Main/appsdropdown';
$route['blocks/menus/material-sidebar.html'] = 'Main/materialsidebar';
$route['blocks/sidebar-user-profile.html'] = 'Main/sidebaruserprofile';

$route['validate-login'] = 'Users/validatelogin';


$route['(:any)/blocks/rightbar/chat.html'] = 'Main/chat';
$route['(:any)/blocks/rightbar/notifications.html'] = 'Main/notifications';
$route['(:any)/blocks/rightbar/activities.html'] = 'Main/activities';
$route['(:any)/blocks/rightbar/cart.html'] = 'Main/cart';
$route['(:any)/blocks/rightbar/settings.html'] = 'Main/settings';
$route['(:any)/blocks/rightbar/rightbar.html'] = 'Main/rightbar';
$route['(:any)/blocks/navbar/user-dropdown.html'] = 'Main/userdropdown';
$route['(:any)/blocks/navbar/apps-dropdown.html'] = 'Main/appsdropdown';
$route['(:any)/blocks/menus/material-sidebar.html'] = 'Main/materialsidebar';
$route['(:any)/blocks/sidebar-user-profile.html'] = 'Main/sidebaruserprofile';


$route['preexportainfojudicial/(:any)'] = 'Main/preexportainfojudicial/$1';
$route['exportainfojudicial'] = 'Main/exportainfojudicial';

$route['preexportadetallellamadas/(:any)'] = 'Main/preexportadetallellamadas/$1';
$route['exportadetallellamadas'] = 'Main/exportadetallellamadas';
$route['exportaestadoclientes/(:any)'] = 'Main/exportaestadoclientes/$1';
$route['generainformebbva'] = 'Operativo/generainformebbva';
$route['exportarinformebbva/(:any)'] = 'Operativo/exportarinformebbva/$1';

$route['generainformebbvatabla'] = 'Operativo/generainformebbvatabla';
$route['generainformebbvaespejo'] = 'Operativo/generainformebbvaespejo';
$route['exportarinformebbvaespejo/(:any)'] = 'Operativo/exportarinformebbvaespejo/$1';
$route['exportarinformebbvatabla/(:any)'] = 'Operativo/exportarinformebbvatabla/$1';



$route['sendformatomail'] = 'Operativo/sendformatomail';

$route['informeprodc/(:any)'] = 'Operativo/informeprodc/$1';



$route['valida-vectores'] = 'Operativo/validavectores';
$route['resultado-eventos-buscar'] = 'Operativo/resultadoeventosbuscar';
$route['enviarAcuerdoFinal'] = 'Operativo/enviaracuerdofinal';
$route['generarCuotasAcuerdo'] = 'Operativo/generarcuotasacuerdo';
$route['generarCuotasAcuerdo2'] = 'Operativo/generarcuotasacuerdo2';
$route['generarAcuerdo'] = 'Operativo/generaracuerdo';
$route['generarAcuerdo2'] = 'Operativo/generaracuerdo2';
$route['generardesistirpdf'] = 'Operativo/generardesistirpdf';
$route['generarpropuestapdf'] = 'Operativo/generarpropuestapdf';
$route['generaracuerdopdf'] = 'Operativo/generaracuerdopdf';
$route['event-search'] = 'Operativo/visoreventos';
$route['visor-eventos'] = 'Operativo/visoreventos';
$route['drop-arbol'] = 'Operativo/droparbol';
$route['save-new-relacion'] = 'Operativo/savenewrelacion';
$route['edit-new-motivo'] = 'Operativo/editnewmotivo';
$route['save-new-motivo'] = 'Operativo/savenewmotivo';
$route['edit-new-resultado'] = 'Operativo/editnewresultado';
$route['save-new-resultado'] = 'Operativo/savenewresultado';
$route['edit-new-contacto'] = 'Operativo/editnewcontacto';
$route['save-new-contacto'] = 'Operativo/savenewcontacto';
$route['edit-new-action'] = 'Operativo/editnewaction';
$route['save-new-action'] = 'Operativo/savenewaction';
$route['arbol/(:any)'] = 'Operativo/arbol/$1';



$route['preexportarinformev1/(:any)'] = 'Main/preexportarinformev1/$1';
$route['exportarinformev1'] = 'Main/exportarinformev1';
$route['preexportarinformev2/(:any)'] = 'Main/preexportarinformev2/$1';
$route['exportarinformev2'] = 'Main/exportarinformev2';


$route['uploadasignacion/(:any)'] = 'Operativo/uploadasignacion/$1';
$route['importarasignacion/(:any)'] = 'Operativo/importarasignacion/$1';
$route['uploadpagoscredivalores/(:any)'] = 'Operativo/uploadpagoscredivalores/$1';
$route['cargarpagoscredivalores/(:any)'] = 'Operativo/cargarpagoscredivalores/$1';

$route['executeactualizacion/(:any)'] = 'Operativo/executeactualizacion/$1';
$route['executebaseinicial/(:any)'] = 'Operativo/executebaseinicial/$1';
$route['uploadbaseinicial/(:any)'] = 'Operativo/uploadbaseinicial/$1';
$route['importarinicial/(:any)'] = 'Operativo/importarinicial/$1';
$route['uploadasignacionini/(:any)'] = 'Operativo/uploadasignacionini/$1';
$route['set-pausa'] = 'Operativo/setpausa';
$route['uploadactualizacion/(:any)'] = 'Operativo/uploadactualizacion/$1';
$route['importarevolutivo/(:any)'] = 'Operativo/importarevolutivo/$1';
$route['importarasignacionini/(:any)'] = 'Operativo/importarasignacionini/$1';
$route['uploadevolutivo/(:any)'] = 'Operativo/uploadevolutivo/$1';
$route['importaractualizacion/(:any)'] = 'Operativo/importaractualizacion/$1';


$route['ranking'] = 'Main/ranking';
$route['localizacion'] = 'Main/localizacion';
$route['saveinfocl'] = 'Main/saveinfocl';
$route['predictivo/(:any)'] = 'Main/predictivo/$1';
$route['generapdf/(:any)'] = 'Main/generapdf/$1';
$route['getdataacuerdooh'] = 'Main/getdataacuerdooh';
$route['creaacuerdo'] = 'Main/creaacuerdo';
$route['generaacuotas'] = 'Main/generaacuotas';
$route['resultadotarea'] = 'Main/resultadotarea';
$route['getprogcall'] = 'Main/getprogcall';
$route['saveprogcall'] = 'Main/saveprogcall';
$route['fastsearchurl/(:any)'] = 'Main/fastsearchurl/$1';
$route['fastsearch'] = 'Main/fastsearch';
$route['logout'] = 'Main/logout';
$route['errorbusqueda'] = 'Main/errorbusqueda';
$route['fintarea'] = 'Main/fintarea';
$route['nexttarea'] = 'Main/nexttarea';
$route['settarea/(:any)'] = 'Main/settarea/$1';
$route['deletetarea/(:any)'] = 'Main/deletetarea/$1';
$route['resumen-asignacion/(:any)'] = 'Operativo/resumenasignacion/$1';
$route['resumen-tareas/(:any)'] = 'Main/resumentareas/$1';
$route['uploadtareas/(:any)'] = 'Main/uploadtareas/$1';
$route['importartareas/(:any)'] = 'Main/importartareas/$1';
$route['getGestion'] = 'Main/getGestion';
$route['gestionasignacion'] = 'Main/gestionasignacion';
$route['savegestion'] = 'Main/savegestion';
$route['getfingestion'] = 'Main/getfingestion';
$route['makememo'] = 'Main/makememo';
$route['getresultadogestion'] = 'Main/getresultadogestion';
$route['getcontactogestion'] = 'Main/getcontactogestion';

$route['savenuevomail'] = 'Main/savenuevomail';
$route['savenuevodir'] = 'Main/savenuevodir';
$route['inactivosmail'] = 'Main/inactivosmail';
$route['inactivosdir'] = 'Main/inactivosdir';
$route['activosmail'] = 'Main/activosmail';
$route['activosdir'] = 'Main/activosdir';
$route['activatedir'] = 'Main/activatedir';
$route['unactivatedir'] = 'Main/unactivatedir';
$route['unactivatemail'] = 'Main/unactivatemail';
$route['activatemail'] = 'Main/activatemail';
$route['detalle-pagos'] = 'Main/detallepagos';

$route['showevolutivo'] = 'Main/showevolutivo';
$route['showasignaciontotal'] = 'Main/showasignaciontotal';
$route['subirarchivo'] = 'Main/subirarchivo';
$route['savenuevotel'] = 'Main/savenuevotel';
$route['inactivostel'] = 'Main/inactivostel';
$route['activostel'] = 'Main/activostel';
$route['activatetel'] = 'Main/activatetel';
$route['unactivatetel'] = 'Main/unactivatetel';
$route['getlistado'] = 'Main/getlistado';
$route['asignacion/(:any)'] = 'Main/asignacion/$1';
$route['cliente/(:any)'] = 'Main/cliente/$1';
$route['resultado-buscar'] = 'Main/resultadobuscar';
$route['buscar/(:any)'] = 'Main/buscar/$1';
$route['dashboard/(:any)'] = 'Main/dashboard/$1';
$route['setpractivo/(:any)'] = 'Main/setpractivo/$1';
$route['dashboard'] = 'Main/landing';
$route['default_controller'] = 'Users/register';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
