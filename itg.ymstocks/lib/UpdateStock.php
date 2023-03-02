<?
namespace Itg\Ymstocks;
use Bitrix\Main\Application;
use Bitrix\Sale;
use Bitrix\Catalog;

/*
   класс реализует обновление всех остатков  на складе, запускается агентом
*/
class UpdateStock
{
	private $token;
	private $client_id;
	// private $campaign_id = '52004283';
	// private $warehouse_id = '554009';

   private $campaign_id ;
   private $warehouse_id;


	private $countProducts;
	private $db;
   private $arResultProducts = [];

	 function __construct()
      {
         $this->db =  \Bitrix\Main\Application::getConnection();
         $this->getOptions();
      }

      /*
            получаем токен и клиент id из настроек модуля яндекс маркет
      */
      private function getOptions()
      {
      	
         // $rs = $this->db->query('SELECT * FROM yamarket_api_oauth2_token');
         // $row = $rs->fetch();
         // $this->token = $row['ACCESS_TOKEN'];
         // $this->client_id = $row['CLIENT_ID'];

         $this->arBrandId =  unserialize( \COption::GetOptionString('itg.ymstocks','brend_id'));
         $this->campaign_id =  \COption::GetOptionString('itg.ymstocks','campaign_id');
         $this->warehouse_id =  \COption::GetOptionString('itg.ymstocks','warehouse_id');
         $this->client_id =  \COption::GetOptionString('itg.ymstocks','client_id');
         $this->store_id =  \COption::GetOptionString('itg.ymstocks','store_id');
         $this->token =  \COption::GetOptionString('itg.ymstocks','token');
      }

      public function test($value='')
      {
          echo "token ".$this->token;
          echo "client_id ".$this->client_id;
          echo "campaign_id ".$this->campaign_id;
          echo "warehouse_id ".$this->warehouse_id;

          echo "test";
      }


      public function getProducts()
      {
         $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
                'filter' => array('=STORE_ID'=>8),           
                'select' => array('PRODUCT_ID','AMOUNT'),
                // 'limit'=>200,
                'count_total'=>true

            ));
          
    
         $skus = array();
               while($arStoreProduct=$rsStoreProduct->fetch())
               {
                               
                  $arTest[] = $arStoreProduct;
                   
               }
         $this->arResultProducts =   array_chunk($arTest,1999,true);
                
         return $this;
      }


      public function createData($ar = [])
      {
          $skus = [];

         if (!empty($ar)) {
            foreach ($ar as $key => $value) {
                
                $sku = array(
                     'sku' => $value['PRODUCT_ID'],
                     'warehouseId' => $this->warehouse_id,
                     'items' => array(
                        array(
                           'type' => 'FIT',
                           'count' => $value['AMOUNT'],
                           'updatedAt' => date('c'),
                        )
                     ), 
                  );

               $skus[] = $sku;
            }
         }

         $data = array(
            "skus" => $skus
         );
         $this->request($data);
      }
      public function dataRequest()
      {
          $arCount =  count($this->arResultProducts);
         
          $i = 0;

          for ($i=0; $i < $arCount; $i++) { 
             
            
             $this->createData($this->arResultProducts[$i]);
             
          }
      }


      private function request($data)
      {  
          echo "переданы остатки ". json_encode($data).'<br>';

         // file_put_contents(__DIR__.'/log_yand.txt',json_encode($data));
         // $ch = curl_init("https://api.partner.market.yandex.ru/v2/campaigns/{$this->campaign_id}/offers/stocks.json");
         // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         //    'Authorization: OAuth oauth_token="' . $this->token . '", oauth_client_id="' . $this->client_id . '"', 
         //    'Content-Type:application/json'
         // ));
         // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
         // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 

         // curl_setopt($ch, CURLOPT_HEADER, true);
         // $res = curl_exec($ch);
         // curl_close($ch);
         // return $res;
      }
   

}