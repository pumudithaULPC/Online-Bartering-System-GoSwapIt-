<?php

class Request_Handle
{
    public function __construct()
    {
        $Controller = Master::GetParameter('controller', 'POST', 'STRING');
        $Action     = Master::GetParameter('action', 'POST', 'STRING');
        $Data       = json_decode($_POST['data']);        

        try
        {

            switch ($Controller)
            {
                case 'category':
                    
                    
                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new CategoryController();
                    $Controller->{$Action}($Data);
                    
                    break;
                
                case 'brand':
                    
                    
                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new BrandController();
                    $Controller->{$Action}($Data);
                    
                    break;
                
		case 'model':
                    
                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new ModelController();
                    $Controller->{$Action}($Data);
                    
                    break;
                
                case 'admin':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new AdminController();
                    $Controller->{$Action}($Data);
                    
                    break;
                
                case 'categoryAttributes':
                    
                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new CategoryAttributesController();
                    $Controller->{$Action}($Data);
                    
                    break;
                
                case 'swapper':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new SwapperController();
                    $Controller->{$Action}($Data);
                    
                    break;

                case 'helpTicket':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new helpTicketController();
                    $Controller->{$Action}($Data);
                    
                    break;
              
                  
                case 'offer':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new OfferController();
                    $Controller->{$Action}($Data);
                    
                    break; 
                
                case 'swap':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new SwapController();
                    $Controller->{$Action}($Data);
                    
                    break;  
                 
                case 'swapInquiry':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new swapInquiryController();
                    $Controller->{$Action}($Data);                   
                    break; 
                
                case 'swapItem':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new SwapItemController();
                    $Controller->{$Action}($Data);                   
                    break;
                
                case 'ticketReply':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new TicketReplyController();
                    $Controller->{$Action}($Data);                   
                    break;
                
                case 'inquiryReply':

                    include_once 'controller/'.$Controller.'_controller.php';
                    $Controller  = new InquiryReplyController();
                    $Controller->{$Action}($Data);                   
                    break;
                
                
                default :
                    throw new Exception("INVALID_REQUEST",1002);
            }
        }
        catch (Exception $e)
        {
            $Code    = $e->getCode();
            $Message = $e->getMessage();
            
            $Response = array('success' => false, 'code' => $Code, 'message' => $Message);

            echo json_encode($Response); 
        }
    }
}