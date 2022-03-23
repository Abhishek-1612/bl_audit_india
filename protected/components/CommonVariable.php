<?php
class CommonVariable {
    public $value = '';
     public $allactiveVenders = '';
    
	 public static function get_autosuggest_js() { 
           $value='//utils.imimg.com/suggest/js/jq-ac-ui-v334.js';
            return $value;
        }        
       
      public static function get_active_vendor_name() {
            		
                                //    $file1 = '/home/indiamart/public_html/gladminfiles/eto_leap_vendor_list.json';
                                //    $json1 = file_get_contents($file1);
                                //    $vendors_list = array();
                                //    $vendors_list = json_decode($json1, true);
                                //    $arr = array();
                                //    $arr = array_column($vendors_list, 'eto_leap_vendor_name');
                                //    $allactiveVenders=$arr;

            $allactiveVenders=array('BANREVIEW','CATEGORY_TRAINING','CATEGORY_WORK','C2CTRAIN','C2CPRACTICE','COMPETENT','COMPETENTDNC','CONNECT_C2C','DDN','DNCTRAIN','IEINBOUND','IENERGIZERPNSMRK','KOCHARTECHLDH','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHINTENT','KOCHARTECHREVIEW','LIVEDIGITAL','LIVEDIGITALFLPNS','NOIDA','OAP_PD','OAP_TRAINING','PRODUCT_APPROV_TRAINING','PRODUCT_APPROV_WORK','RADIATEINTENT','RADIATEPNSTOBL','RADIATEPNSMRK','RADIATEAUTO','VKALPAUTOIND','VKALPDNC','VKALPINTENT','VKALPREVIEW','REGIONAL_OAP_TAMIL','REGIONAL_OAP_TELUGU','REGIONAL_OAP_KANNADA','REGIONAL_OAP_MALAYALAM');
            return $allactiveVenders;
        }
        public static function get_active_vendor_list() { 
            // $allactiveVenders=array();
            // $file1 = '/home/indiamart/public_html/gladminfiles/eto_leap_vendor_list.json';
            // $json1 = file_get_contents($file1);
            // $vendors_list = array();
            // $vendors_list = json_decode($json1, true);
            // $arr = array();
            // for($i=0;$i<count($vendors_list);$i++) {
            //     $allactiveVenders[$vendors_list[$i]['eto_leap_vendor_id']]=$vendors_list[$i]['eto_leap_vendor_name'];
            //   }
            $allactiveVenders=array('31'=>'BANREVIEW','47'=>'CATEGORY_TRAINING','48'=>'CATEGORY_WORK','44'=>'C2CTRAIN','45'=>'C2CPRACTICE','4'=>'COMPETENT','34'=>'COMPETENTDNC','40'=>'CONNECT_C2C','18'=>'DDN','43'=>'DNCTRAIN','25'=>'IEINBOUND','32'=>'IENERGIZERPNSMRK','14'=>'ILEAD','28'=>'KOCHARTECHAUTO','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW','33'=>'LIVEDIGITAL','35'=>'LIVEDIGITALFLPNS','9'=>'NOIDA','51'=>'OAP_PD','52'=>'OAP_TRAINING','49'=>'PRODUCT_APPROV_TRAINING','50'=>'PRODUCT_APPROV_WORK','24'=>'RADIATEAUTO','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL','10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW','57'=>'REGIONAL_OAP_MALAYALAM','54'=>'REGIONAL_OAP_TAMIL','55'=>'REGIONAL_OAP_TELUGU','56'=>'REGIONAL_OAP_KANNADA');
            return $allactiveVenders;
        }


        //  public static function get_active_vendor_name() {

        //    if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')
        //    {
        //        $allactiveVenders=array('BANREVIEW','CATEGORY_TRAINING','CATEGORY_WORK','C2CTRAIN','C2CPRACTICE','COMPETENT','COMPETENTDNC','CONNECT_C2C','DDN','DNCTRAIN','IEINBOUND','IENERGIZERPNSMRK','KOCHARTECHLDH','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHINTENT','KOCHARTECHREVIEW','LIVEDIGITAL','LIVEDIGITALFLPNS','NOIDA','OAP_PD','OAP_TRAINING','PRODUCT_APPROV_TRAINING','PRODUCT_APPROV_WORK','RADIATEINTENT','RADIATEPNSTOBL','RADIATEPNSMRK','RADIATEAUTO','VKALPAUTOIND','VKALPDNC','VKALPINTENT','VKALPREVIEW','REGIONAL_OAP_TAMIL','REGIONAL_OAP_TELUGU','REGIONAL_OAP_KANNADA','REGIONAL_OAP_MALAYALAM');
        //    }
        //    else
        //    {
        //          $file1 = '/home/indiamart/public_html/gladminfiles/eto_leap_vendor_list.json';
        //         $json1 = file_get_contents($file1);
        //         $vendors_list = array();
        //         $vendors_list = json_decode($json1, true);
        //         $arr = array();
        //         $arr = array_column($vendors_list, 'eto_leap_vendor_name');
        //         $allactiveVenders=$arr;
        //    }

        //     return $allactiveVenders;
        // }
        // public static function get_active_vendor_list() {

        //      $allactiveVenders=array();
        //     if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')
        //    {
        //       $allactiveVenders=array('31'=>'BANREVIEW','47'=>'CATEGORY_TRAINING','48'=>'CATEGORY_WORK','44'=>'C2CTRAIN','45'=>'C2CPRACTICE','4'=>'COMPETENT','34'=>'COMPETENTDNC','40'=>'CONNECT_C2C','18'=>'DDN','43'=>'DNCTRAIN','25'=>'IEINBOUND','32'=>'IENERGIZERPNSMRK','14'=>'ILEAD','28'=>'KOCHARTECHAUTO','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW','33'=>'LIVEDIGITAL','35'=>'LIVEDIGITALFLPNS','9'=>'NOIDA','51'=>'OAP_PD','52'=>'OAP_TRAINING','49'=>'PRODUCT_APPROV_TRAINING','50'=>'PRODUCT_APPROV_WORK','24'=>'RADIATEAUTO','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL','10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW','57'=>'REGIONAL_OAP_MALAYALAM','54'=>'REGIONAL_OAP_TAMIL','55'=>'REGIONAL_OAP_TELUGU','56'=>'REGIONAL_OAP_KANNADA');
        //    }
        //    else
        //    {

        //         $file1 = '/home/indiamart/public_html/gladminfiles/eto_leap_vendor_list.json';
        //         $json1 = file_get_contents($file1);
        //         $vendors_list = array();
        //         $vendors_list = json_decode($json1, true);
        //         $arr = array();
        //         for($i=0;$i<count($vendors_list);$i++) {
        //             $allactiveVenders[$vendors_list[$i]['eto_leap_vendor_id']]=$vendors_list[$i]['eto_leap_vendor_name'];
        //         }
        //    }
        //     return $allactiveVenders;
        // }

        
        public static function get_keywordtype() {

            $arr=array();
            $arr["label"]=array("1"=>"Product Type Search","2"=>"With ISQ","3"=>"With City","4"=>"Service type search","5"=>"Brand","6"=>"ing machine Search","7"=>"Spare Part","8"=>"QTY and Unit Search","9"=>"Slang-Abbreviation-Symbol","10"=>"With used","11"=>"Job Work","12"=>"With Model","13"=>"NOB Type Search","14"=>"Misspell","15"=>"Banned","16"=>"LongKeywords","17"=>"Synonym","18"=>"Raw Material");
            $arr["keyword"]=array("19"=>"Make Every Effort but no Irrelevancy Noticed","20"=>"Less Products","21"=>"Zero Products","22"=>"Less/Zero Supplier in Searched City","23"=>"Wrong Suggested Mcat","24"=>"Findability Issue","25"=>"Generic keyword","26"=>"Illogical /Invalid Query","27"=>"Specific Company not exist","28"=>"Wrong Mapping","29"=>"Long Query issue","30"=>"Filter Related Issue","31"=>"Spell_Correction not available","32"=>"Alternate Name Issue","KWPL Issue","33"=>"Compound word Issues","34"=>"Filter- related Issue","35"=>"Wrong Image","36"=>"Localization Issue","37"=>"Wrong Price/ISQ/Description","38"=>"Wrong Title","39"=>"Miss Spelled Product Title","40"=>"Brand name Logic Issue","41"=>"Synonyms Issues","42"=>"Complaining about Buylead","43"=>"Phonetic Related Issue","44"=>"Company Not in Search","45"=>"Company search by Product","46"=>"Wrong custom messege");
            return json_encode($arr);
       
        }
    
	   
	     
    public static function get_turnover_values() { 
          
            $turnover_values = array
            (
                "50"=>"Upto Rs. 50 Lakh",
                "100"=>"Rs. 50 Lakh - 1 Crore",
                "150"=>"Rs. 1 - 2 Crore",
                "200"=>"Rs. 2 - 5 Crore",
                "250"=>"Rs. 5 - 10 Crore",
                "300"=>"Rs. 10 - 25 Crore",
                "350"=>"Rs. 25 - 50 Crore",
                "400"=>"Rs. 50 - 100 Crore",
                "500"=>"Rs. 100 - 500 Crore",
                "600"=>"Rs. 500 - 1000 Crore",
                "700"=>"Rs. 1000 - 5000 Crore",
                "800"=>"Rs. 5000 - 10000 Crore",
                "900"=>"More than Rs. 10000 Crore"
                );
            return $turnover_values;
        }

        public static function get_employee_for_blni() { 
          
            $get_emp_BLNI = array
            (
                "4974"=>"Kamal Talwar",
                "33104"=>"Pranav Jolly",
                "66466"=>"Priyanka Tanwar",
                "66495"=>"Mohak Verma",
                "71609"=>"Jaiveer Singh",
                "71868"=>"Sunita Chaudhary",
                "20683"=>"Amit Dhiman",
                "23669"=>"Ankur Verma",
                "31187"=>"Zeba Zaidi",
                "32235"=> "Henna Joshi",
                "62854"=> "Deepshikha Lal",
                "59962"=> "Mansha Arora",
                "71190" => "Sunidhi Chauhan",
                "72113"=>"Gaurav Gairola",
                "45600" => "Debasish",
                "74575"=>"Rohit kumar"
                );
            return $get_emp_BLNI;
        }
        public static function get_micro_dispositions() { 
          
            $get_micro_dispositions = array
            (
                "1"=>"Buy Lead Generic + Precise Mapping",
                "2"=>"Insufficient Details In Buy Lead",
                "3"=>"Buy Lead Generated Inspite of Low Suppliers Count",
                "4"=>"Buy Lead Mapped in Generic MCAT (Specific MCAT N/A)",
                "5"=>"Buy Lead Wrong Mapping",
                "6"=>"Multiple Products in Buy Lead",
                "7"=>"Wrong Buy Lead Approved/Original Requirement Changed",
                "8"=>"Leap Associate Wrong Searched Keyword/Wrong Supplier Selection",
                "9"=>"Buyer's Preferred Location & Supplier's Location Mismatch",
                "10"=> "D Rank Alert Last Purchase Issue",
                "11"=> "Rejection With the Wrong Disposition",
                "12"=> "Client Mistakenly Marked Irrelevant",
                "13" => "Obsolete Product",
                "14"=>"User Wrong Input",
                "15" => "Associate Generic Product Mapping When Precise Mcat Available",
                "16"=>"Generic Plus Precise Product Mapping (Not Removed)",
                "17"=>"Generic Plus Precise Product Mapping (Removed)",
                "18"=> "Associate Wrong Product Mapping",
                "19"=> "Generic Product Mapping Due To Mcat N/A (Not Removed)",
                "20"=> "Generic Product Mapping Due To Mcat N/A (Removed)",
                "21" => "Auto Generic Product Mapping When Precise Mcat Available",
                "22"=>"Auto Wrong Product Mapping",
                "23" => "Generic Product Nomenclature",
                "24"=>"Rejection On Old Astbuy After Product/Alert Removal",
                "25"=> "Wrong Product In Catalog",
                "26" => "Wrong Product Title",
                "27"=>"Wrong MCAT Suggestions By Search",
                "28" => "Wrong Supplier Results By Search",
                "29"=>"Brand Mismatch",
                "30"=> "Specification Mismatch",
                "31" => "Product Out Of Stock",
                "32"=>"Others"
                );
            return $get_micro_dispositions;
        }

         public static function get_final_dispositions() { 
            $get_final_dispositions = array
            (
                "1"=>"D Rank MCAT",
                "2"=>"Wrong Input By User",
                "3"=>"Wrong Input By IndiaMART",
                "4"=>"Wrong Mapping At LEAP",
                "5"=>"Wrong Mapping At  Search",
                "6"=>"Taxonomy Issue",
                "7"=>"Location Issue",
                "8"=>"Specification Issue",
                "9"=>"Others"
            );
            return $get_final_dispositions;
        }


           public static function get_noof_values() { 
          
            $noof_values = array
            (
                "100"=>"Upto 10 People",
                "200"=>"11 to 25 People",                
                "300"=>"26 to 50 People",               
                "400"=>"51 to 100 People",
                "500"=>"101 to 500 People",  
                "600"=>"501 to 1000 People",
                "700"=>"1001 to 2000 People",
                "800"=>"2001 to 5000 People",
                "900"=>"More than 5000 People"
                );
            return $noof_values;
        }
                public static function GetPrimaryBizNature_values() { 
          
            $PrimaryBiz_values = array // data from GLUSR_BIZ
            (
                "10"=>"Manufacturer",
                "20"=>"Exporter",                
                "30"=>"Wholesaler",               
                "100"=>"Trader",
                "40"=>"Retailer",  
                "90"=>"Buying House",
                "70"=>"Buyer-Company",
                 "60"=>"Buyer-Individual",
                "50"=>"Service Provider",                
                "80"=>"Non Profit Organization",               
                "120"=>"Association",
                "130"=>"Importer",  
                "140"=>"Supplier",
                "150"=>"Distributor"          
                );
            return $PrimaryBiz_values;
        }
               public static function GetBizNature_values() { 
          
//            $PrimaryBiz_values = array // data from GL_PRIMARY_BIZ
//            (
//                "10"=>"Manufacturer",
//                "20"=>"Exporter",                
//                "30"=>"Wholesaler",               
//                "100"=>"Trader",
//                "40"=>"Retailer",  
//                "90"=>"Buying House",
//                "70"=>"Buyer-Company",
//                 "60"=>"Buyer-Individual",
//                "50"=>"Service Provider",                
//                "80"=>"Non Profit Organization",               
//                "120"=>"Association",
//                "130"=>"Importer",  
//                "140"=>"Supplier",
//                "150"=>"Distributor"          
//                );
//            return $PrimaryBiz_values;
            //new values******************************************
            
          
            $PrimaryBiz_values = array
            (
                "10"=>"Manufacturer",
                "59"=>"Animal / Crop Production",                
                "11"=>"OEM Manufacturer",               
                "65"=>"Producers",
                "20"=>"Exporter",  
                "21"=>"100% Export Oriented Unit",
                "30"=>"Wholesaler",
                "36"=>"Authorized Wholesale Dealer",
                "37"=>"Distributor / Channel Partner",                
                "38"=>"Importer",               
                "31"=>"Wholesale Distributor",
                "32"=>"Wholesale Merchants",  
                "33"=>"Wholesale Sellers",
                "34"=>"Wholesale Supplier",
                "35"=>"Wholesale Trader",
                "40"=>"Retailer",                
                "41"=>"Retail Merchants",               
                "43"=>"Authorized Retail Dealer",
                "40"=>"Retailer",  
                "42"=>"Retail Shop",
                "44"=>"Ecommerce Shop / Online Business",
                "46"=>"Retail Showroom",
                "45"=>"Retail Trader",                
                "50"=>"Service Provider",               
                "64"=>"Architect / Interior Design / Town Planner",
                "63"=>"Bakery / Caterer",  
                "51"=>"Consultants",
                "62"=>"Equipment Rental",
                "66"=>"Fabricators",                
                "52"=>"Hotels / Restaurants",               
                "61"=>"IT / Technology Services",
                "53"=>"Legal Advisor / Legal Help",  
                "54"=>"Non Profit Organization",
                "55"=>"Nursing Homes / Clinics / Hospitals",
                "67"=>"Plumbing / Remodeling / Repair / Maintenance",               
                "68"=>"Buying House",
                "56"=>"Real Estate / Builders / Contractors",  
                "57"=>"School / College / Coaching / Tuition / Hobby Classes",
                "60"=>"Stones / Minerals Mining / Cutting / Polishing",
                "58"=>"Travel / Travel Agents / Transportation Services",
                "200"=>"Other"
                               
                );
            return $PrimaryBiz_values;
        
            }
                  public static function GetOwnerShip_values() { 
          
            $ownership_values = array
            (
                "4"=>"Individual - Proprietor",
                "3"=>"Partnership Firm",               
                "2"=>"Limited Company ( Ltd. / Pvt. Ltd. )",                
                "6"=>"Limited Liability Partnership (LLP)",
                "15"=>"HUF Firm (Hindu Undivided Family)",
                "5"=>"Trust / Association of Person / Body of Individual",  
                "12"=>"Government / Local Authority / Artificial Judiciary"
                );
            return $ownership_values;
        }
        
        public static function get_glunit() { 
            return array("20' Container","40' Container","Bag","Barrel","Bottle","Box","Bushel","Carat","Carton","Cubic Feet","Cubic Meter","Day","Dozen","Foot","Gallon","Gram","Hour","Hectare","Kilogram","Kilometer","Litre","Long Ton","Meter","Metric Ton","Number","Ounce","Pack","Packet","Pair","Person","Piece","Pound","Ream","Roll","Set","Sheet","Short Ton","Square Feet","Square Meter","Strip","Ton","Unit","Watt","Megawatts","Kilowatt","Inch","Millimeter","Plate","Person","Annum","Centimeter","Micrometer","Feet","Mile","Square Inch","Square Millimeter","Acre","Milliliter","Cubic Centimeter","Cubic Inch","Gallon","Microgram","GigaWatt","TeraWatt","Celcius","Fahrenheit","Kelvin","Second","Minute","Month","Year","Running Feet","Gross","Area ","Bunch ","Bundle ","Container ","Gallon ","Metric Ton ","Milligram","Page","Plant","Pouch","Quintal","Ream","Room","Running Feet","Vial","Visit","Yard","Pounds Per Square Inch","Order","Kit","Tablet");
        }

        
        public static function get_language_values() { 
          
            $ownership_values = array
            (
                "1"=>"English",
                "2"=>"Hindi",                
                "3"=>"Bengali",               
                "4"=>"Tamil",
                "5"=>"Marathi",  
                "6"=>"Urdu",
                "7"=>"Gujarati", 
                "8"=>"Telugu", 
                "9"=>"Sanskrit", 
                "10"=>"Kannada", 
                "11"=>"Malayalam", 
                "12"=>"Punjabi", 
                "13"=>"Odia", 
                "14"=>"Mizo", 
                "15"=>"Assamese", 
                "16"=>"Nepali",                            
                "17"=>"Meitei (Manipuri)", 
                "18"=>"Khasi", 
                "19"=>"Nagamese", 
                "20"=>"Konkani"              
                );
            return $ownership_values;
        }

	//mesh independent marketplace

 public static function get_mcat_type() { 
          
            $type_values = array
            (
	

                "1"=>"Super PMCAT",
                "2"=>"Good PMCAT",                
                "3"=>"Thin PMCAT",               
                "4"=>"Normal MCAT",
                "5"=>"Duplicate MCAT",  
                "6"=>"Brand MCAT"
                );
            return $type_values;
        }
public static function get_country_name() { 
    
    $type_values = array
    (
        'SR'=> array("Suriname", 597),
        'SZ'=> array("Swaziland", 268),
        'SE'=> array("Sweden", 46),
        'CH'=> array("Switzerland", 41),
        'SY'=> array("Syria", 963),
        'TW'=> array("Taiwan", 886),
        'TJ'=> array("Tajikistan", 992),
        'TZ'=> array("Tanzania", 255),
        'TH'=> array("Thailand", 66),
        'TG'=> array("Togo", 228),
        'TK'=> array("Tokelau", 690),
        'TO'=> array("Tonga", 676),
        'TT'=> array("Trinidad And Tobago", 91),
        'TN'=> array("Tunisia", 91),
        'TR'=> array("Turkey", 91),
        'TM'=> array("Turkmenistan", 91),
        'TC'=> array("Turks And Caicos Islands", 1-649),
        'TV'=> array("Tuvalu", 688),
        'UG'=> array("Uganda", 256),
        'UA'=> array("Ukraine", 380),
        'AE'=> array("United Arab Emirates", 971),
        'UK'=> array("United Kingdom", 44),
        'UM'=> array("United States Minor Outlying I", 246),
        'UY'=> array("Uruguay", 598),
        'UZ'=> array("Uzbekistan", 998),
        'VU'=> array("Vanuatu", 678),
        'VA'=> array("Holy See", 379),
        'VE'=> array("Venezuela", 58),
        'VN'=> array("Vietnam", 84),
        'VG'=> array("Virgin Islands (British)", 1-284),
        'VI'=> array("Virgin Islands (Us)", 1-340),
        'WF'=> array("Wallis And Futuna Islands", 681),
        'EH'=> array("Western Sahara", 212),
        'YE'=> array("Yemen", 967),
        'YU'=> array("Yugoslavia", 38),
        'ZM'=> array("Zambia", 260),
        'PS'=> array("Palestinian National Authority", 970),
        'AB'=> array("ARABIC", ''),
        'SS'=> array("South Sudan", 211),
        'AZ'=> array("Azerbaijan", 994),
        'BO'=> array("Bolivia", 591),
        'BF'=> array("Burkina Faso", 226),
        'MO'=> array("China (Macau S.A.R.)", 853),
        'CU'=> array("Cuba", 53),
        'DM'=> array("Dominica", 1-767),
        'ET'=> array("Ethiopia", 251),
        'PF'=> array("French Polynesia", 689),
        'GU'=> array("Guam", 1-671),
        'HM'=> array("Heard And Mcdonald Islands", 672),
        'KI'=> array("Kiribati", 686),
        'LS'=> array("Lesotho", 266),
        'MW'=> array("Malawi", 265),
        'MQ'=> array("Martinique", 596),
        'MS'=> array("Montserrat", 1-664),
        'NZ'=> array("New Zealand", 64),
        'PW'=> array("Palau", 680),
        'PL'=> array("Poland", 48),
        'RU'=> array("Russia", 7),
        'VC'=> array("Saint Vincent And The Grenadin", 1-784),
        'CS'=> array("Serbia And Montenegro", 381),
        'TL'=> array("East Timor", 670),
        'GI'=> array("Gibraltar", 350),
        'HN'=> array("Honduras", 504),
        'JP'=> array("Japan", 81),
        'KW'=> array("Kuwait", 965),
        'LT'=> array("Lithuania", 370),
        'MU'=> array("Mauritius", 230),
        'NR'=> array("Nauru", 674),
        'NG'=> array("Nigeria", 234),
        'PY'=> array("Paraguay", 595),
        'RW'=> array("Rwanda", 250),
        'SA'=> array("Saudi Arabia", 966),
        'SJ'=> array("Svalbard And Jan Mayen Islands", 47),
        'US'=> array("United States Of America", 1),
        'ZW'=> array("Zimbabwe", 263),
        'RS'=> array("Serbia", 381),
        'ME'=> array("Montenegro", 382),
        'AF'=> array("Afghanistan", 93),
        'AL'=> array("Albania", 355),
        'DZ'=> array("Algeria", 213),
        'AS'=> array("American Samoa", 1-684),
        'AD'=> array("Andorra", 376),
        'AO'=> array("Angola", 244),
        'AI'=> array("Anguilla", 1-264),
        'AQ'=> array("Antarctica", 672),
        'AG'=> array("Antigua And Barbuda", 1-268),
        'AR'=> array("Argentina", 54),
        'AM'=> array("Armenia", 374),
        'AW'=> array("Aruba", 297),
        'AU'=> array("Australia", 61),
        'AT'=> array("Austria", 43),
        'BS'=> array("Bahamas", 1-242),
        'BH'=> array("Bahrain", 973),
        'BD'=> array("Bangladesh", 880),
        'BB'=> array("Barbados", 1-246),
        'BY'=> array("Belarus", 375),
        'BE'=> array("Belgium", 32),
        'BZ'=> array("Belize", 501),
        'BJ'=> array("Benin", 229),
        'BM'=> array("Bermuda", 1-441),
        'BT'=> array("Bhutan", 975),
        'BA'=> array("Bosnia And Herzegovina", 387),
        'BW'=> array("Botswana", 267),
        'BV'=> array("Bouvet Island", 47),
        'BR'=> array("Brazil", 55),
        'IO'=> array("British Indian Ocean Territory", 246),
        'BN'=> array("Brunei", 673),
        'BG'=> array("Bulgaria", 359),
        'BI'=> array("Burundi", 257),
        'KH'=> array("Cambodia", 855),
        'CM'=> array("Cameroon", 237),
        'CA'=> array("Canada", 1),
        'CV'=> array("Cape Verde", 238),
        'KY'=> array("Cayman Islands", 1-345),
        'CF'=> array("Central African Republic", 236),
        'TD'=> array("Chad", 235),
        'CL'=> array("Chile", 56),
        'CN'=> array("China", 86),
        'HK'=> array("China (Hong Kong S.A.R.)", 852),
        'CX'=> array("Christmas Islands", 61),
        'CC'=> array("Cocos Islands", 891),
        'CO'=> array("Colombia", 57),
        'KM'=> array("Comoros", 269),
        'CG'=> array("Congo", 242),
        'CD'=> array("Democractic Republic Of Congo", 243),
        'CK'=> array("Cook Islands", 682),
        'CR'=> array("Costa Rica", 506),
        'CI'=> array("Cote D Ivoire", 225),
        'HR'=> array("Croatia", 385),
        'CY'=> array("Cyprus", 357),
        'CZ'=> array("Czech Republic", 420),
        'DK'=> array("Denmark", 45),
        'DJ'=> array("Djibouti", 253),
        'DO'=> array("Dominican Republic", 1-809),
        'EC'=> array("Ecuador", 593),
        'EG'=> array("Egypt", 20),
        'SV'=> array("El Salvador", 503),
        'GQ'=> array("Equatorial Guinea", 240),
        'ER'=> array("Eritrea", 291),
        'EE'=> array("Estonia", 372),
        'FK'=> array("Falkland Islands", 500),
        'FO'=> array("Faroe Islands", 298),
        'FJ'=> array("Fiji Islands", 679),
        'FI'=> array("Finland", 358),
        'FR'=> array("France", 33),
        'GF'=> array("French Guiana", 594),
        'TF'=> array("French Southern Territories", 262),
        'GA'=> array("Gabon", 241),
        'GM'=> array("The Gambia", 220),
        'GE'=> array("Georgia", 995),
        'DE'=> array("Germany", 49),
        'GH'=> array("Ghana", 233),
        'GR'=> array("Greece", 30),
        'GL'=> array("Greenland", 299),
        'GD'=> array("Grenada", 1-473),
        'GP'=> array("Guadeloupe", 590),
        'GT'=> array("Guatemala", 502),
        'GN'=> array("Guinea", 224),
        'GW'=> array("Guinea-Bissau", 245),
        'GY'=> array("Guyana", 592),
        'HT'=> array("Haiti", 509),
        'HU'=> array("Hungary", 36),
        'IS'=> array("Iceland", 354),
        'IN'=> array("India", 91),
        'ID'=> array("Indonesia", 62),
        'IR'=> array("Iran", 98),
        'IQ'=> array("Iraq", 964),
        'IE'=> array("Ireland", 353),
        'IL'=> array("Israel", 972),
        'IT'=> array("Italy", 39),
        'JM'=> array("Jamaica", 1-876),
        'JO'=> array("Jordan", 962),
        'KZ'=> array("Kazakhstan", 7),
        'KE'=> array("Kenya", 254),
        'KR'=> array("Korea", 82),
        'HP'=> array("Korea, North", 850),
        'KG'=> array("Kyrgyzstan", 996),
        'LA'=> array("Lao People's Democratic Republic", 856),
        'LV'=> array("Latvia", 371),
        'LB'=> array("Lebanon", 961),
        'LR'=> array("Liberia", 231),
        'LY'=> array("Libya", 218),
        'LI'=> array("Liechtenstein", 423),
        'LU'=> array("Luxembourg", 352),
        'MK'=> array("Macedonia", 389),
        'MG'=> array("Madagascar", 261),
        'MY'=> array("Malaysia", 60),
        'MV'=> array("Maldives", 960),
        'ML'=> array("Mali", 223),
        'MT'=> array("Malta", 356),
        'MH'=> array("Marshall Islands", 692),
        'MR'=> array("Mauritania", 222),
        'YT'=> array("Mayotte", 269),
        'MX'=> array("Mexico", 52),
        'FM'=> array("Micronesia", 691),
        'MD'=> array("Moldova", 373),
        'MC'=> array("Monaco", 377),
        'MN'=> array("Mongolia", 976),
        'MA'=> array("Morocco", 212),
        'MZ'=> array("Mozambique", 258),
        'MM'=> array("Myanmar", 95),
        'NA'=> array("Namibia", 264),
        'NP'=> array("Nepal", 977),
        'AN'=> array("Netherlands Antilles", 599),
        'NL'=> array("The Netherlands", 31),
        'NC'=> array("New Caledonia", 687),
        'NI'=> array("Nicaragua", 505),
        'NE'=> array("Niger", 227),
        'NU'=> array("Niue", 683),
        'NF'=> array("Norfolk Island", 672),
        'MP'=> array("Northern Mariana Islands", 1-670),
        'NO'=> array("Norway", 47),
        'OM'=> array("Oman", 968),
        'PK'=> array("Pakistan", 92),
        'PA'=> array("Panama", 507),
        'PG'=> array("Papua New Guinea", 675),
        'PE'=> array("Peru", 51),
        'PH'=> array("Philippines", 63),
        'PN'=> array("Pitcairn Island", 872),
        'PT'=> array("Portugal", 351),
        'PR'=> array("Puerto Rico", 1),
        'QA'=> array("Qatar", 974),
        'RE'=> array("Reunion", 262),
        'RO'=> array("Romania", 40),
        'SH'=> array("Saint Helena", 290),
        'KN'=> array("Saint Kitts And Nevis", 1-869),
        'LC'=> array("Saint Lucia", 1-758),
        'PM'=> array("Saint Pierre And Miquelon", 508),
        'WS'=> array("Samoa", 685),
        'SM'=> array("San Marino", 378),
        'ST'=> array("Sao Tome And Principe", 239),
        'SN'=> array("Senegal", 221),
        'SC'=> array("Seychelles", 248),
        'SL'=> array("Sierra Leone", 232),
        'SG'=> array("Singapore", 65),
        'SK'=> array("Slovakia", 421),
        'SI'=> array("Slovenia", 386),
        'SB'=> array("Solomon Islands", 677),
        'SO'=> array("Somalia", 252),
        'ZA'=> array("South Africa", 27),
        'GS'=> array("South Georgia", 995),
        'ES'=> array("Spain", 34),
        'LK'=> array("Sri Lanka", 94),
        'SD'=> array("Sudan", 249)
        );
        

    return $type_values;
}
        
        
 public static function get_modid_type(){
     
     $type_values=array(
        "AGGRPCAT"=>"Aggregate Product Catalog",
        "AGRO"=>"Indian Agriculture Industry Portal",
        "ANDROID"=>"IM Android App",
        "APR"=>"Indian Apparel  Portal",
        "ASTBUY"=>"Assisted Buying",
        "ASTBUYM"=>"ASTBUYM",
        "AUC"=>"Indian Auction Portal",
        "AUTO"=>"Auto",
        "AUTOOEM"=>"Automobile OEM",
        "AUTOONLI"=>"Automotive Online",
        "BBS"=>"Discussion Boards",
        "BFEEDBCK"=>"BFEEDBCK",
        "BIGBUYER"=>"BIGBUYER",
        "BIZFEED"=>"BIZFEED",
        "BLAFFLT"=>"Buy Leads Affiliates",
        "BLCFORM"=>"BLCFORM",
        "BLINTENT"=>"Buy Leads Intent",
        "BUYRCALL"=>"BUYRCALL",
        "CALLBACK"=>"CallBack",
        "CINTENT"=>"CINTENT",
        "CITYPDIA"=>"City Pedia",
        "CLICKI"=>"Click India",
        "CRAFTCEN"=>"Craft Central",
        "CTL"=>"Business Catalogs",
        "DIGITVTY"=>"Digitivity - Electrical / Electronics",
        "DINDIA"=>"Destination India",
        "DIR"=>"Business Directories & Yellow Pages",
        "DTRADER"=>"Daily Trader",
        "EASYBUY"=>"EASYBUY",
        "EHT"=>"Hello Trade Events",
        "EIM"=>"Events Indiamart",
        "EMKTG"=>"EMKTG",
        "ETO"=>"Indian Trade Portal",
        "EXIM"=>"Indian Export Import Portal",
        "EXPFOC"=>"EXPORT FOCUS",
        "FASHION"=>"Fashion And Beauty",
        "FCP"=>"FREE CATALOG PAGE",
        "FENQ"=>"PBL From Free Enquiries",
        "FFEXT"=>"FFext",
        "FINTENT"=>"FINTENT",
        "FLPNS"=>"FAILPNS",
        "FMP"=>"Furniture Manufacturers",
        "FOSBL"=>"Feet on Street Buy Leads",
        "FOSMERP"=>"FOSMERP",
        "FRL"=>"IndiaMART Freelisting & Business Directories",
        "FUSIONA"=>"FUSION_A",
        "FUSIONB"=>"Fusion-Blackberry",
        "FUSIOND"=>"FUSION-Desktop Windows App",
        "FUSIONI"=>"FUSION_I",
        "FUSIONM"=>"FUSION_M",
        "FUSIONW"=>"FUSIONW",
        "GLADMIN"=>"Gladmin",
        "HANDI"=>"Handicraft",
        "HAR"=>"Hardware Marketplace",
        "HEALTH"=>"Health",
        "HELLOTD"=>"Hello Trade",
        "HELLOTR"=>"HELLOTR",
        "HLTHCARE"=>"Healthcare",
        "HTBUYER"=>"Hello Trade Buyers",
        "HTFCP"=>"HelloTrade Free Catalog Page",
        "HTO"=>"Hand Tools",
        "HTVENDOR"=>"Hello Trade Vendor",
        "ICP"=>"Indian Chemical Portal",
        "IEP"=>"Indian Exporters Portal",
        "IIND"=>"Indian Industry Portal",
        "IIP"=>"Indian Importers Portal",
        "ILP"=>"Indian Leather Portal",
        "IMAPP"=>"Mobile Apps",
        "IMFCP"=>"IMFCP",
        "IMFCPFRM"=>"Indiamart FCP Form",
        "IMHOME"=>"IMHOME",
        "IMOB"=>"Indiamart Mobile",
        "IMVENDOR"=>"Indiamart Vendor",
        "INDIFI"=>"INDIFI",
        "INDUSTRY"=>"Industry Mart",
        "INE"=>"Indian Data",
        "INTENT"=>"INTENT",
        "IOS"=>"IM IOS APP",
        "IPP"=>"Indian Plastic Portal",
        "ITP"=>"Indian Travel Portal",
        "KOREA"=>"KOREA",
        "LABEQUIP"=>"Laboratory Equipment World",
        "LEAP"=>"BL-Leap CRM ",
        "LEAPIN"=>"LEAP-IN",
        "LEAPINEQ"=>"LEAP-IN-ENQ",
        "LOT"=>"Leaders of Tomorrow",
        "MAILREAD"=>"MAILREAD",
        "MDC"=>"MDC",
        "MERP"=>"Mobile MERP",
        "METALCAS"=>"The Metal Casting",
        "MINRZONE"=>"Minerals Zone",
        "MORE"=>"MORE",
        "MTFR"=>"Mobile Biz Trade Shows",
        "MY"=>"MY",
        "NDTV"=>"NDTV",
        "NEWS"=>"News",
        "NMCC"=>"Project Vikas",
        "NSD"=>"NSD",
        "NSDDATA"=>"NSD DATA CALL BUY LEADS",
        "NSDMERP"=>"NSDMERP",
        "OLFCP"=>"OLFCP",
        "PAY"=>"PAY",
        "PAYWIM"=>"PAYWIM",
        "PAYX"=>"PAYX",
        "PBC"=>"Private Buyer Catalog",
        "PCAT"=>"Product Catalog",
        "PDFIM"=>"PDF.INDIAMART.Com",
        "PDTPTL"=>"Product Portal",
        "PERSWID"=>"Personalization",
        "PHARMA"=>"Pharmaceutical Drug Manufacturers",
        "PNS"=>"Preferred Number Service",
        "PNSBLENQ"=>"PNSBLENQ",
        "PNSFEED"=>"PNSFEED",
        "PRF"=>"IndiaMART Business Services",
        "PROCMART"=>"PROCMART",
        "PRODDTL"=>"Product Detail Page",
        "QCHOME"=>"QCHOME",
        "QCSITE"=>"QCSITE",
        "RUGCARP"=>"Rug And Carpets",
        "SAAB"=>"SAAB",
        "SAMPARK"=>"SAMPARK",
        "SELLERMY"=>"SELLERMY",
        "SELLERS"=>"IndiaMART Sellers",
        "SEM"=>"Search Engine Marketing",
        "SII"=>"Sales In India",
        "SIMC"=>"IndiaMART Sourcing",
        "SINTENT"=>"SINTENT",
        "SPORTGDS"=>"Sporting Goods Industry",
        "STDPRD"=>"Standard Product Page",
        "SURFIND"=>"Surfindia",
        "TAB"=>"TAB",
        "TDR"=>"Indian Tenders Portal",
        "TDW"=>"TDW",
        "TDWIM"=>"TDWIM",
        "TEONLINE"=>"TEonline",
        "TEXP"=>"Trade Express",
        "TFR"=>"Biz Trade Shows",
        "TFRS"=>"Biz Trade Shows Supplier Enquiries",
        "TNDRZL"=>"Tenders Zeal",
        "TOLEXO"=>"TOLEXO",
        "TOLEXOM"=>"TOLEXOM",
        "TOLLFREE"=>"TOLLFREE",
        "TPM"=>"The Packers Movers",
        "TRAVELOG"=>"India Travelog",
        "TSD"=>"TSD",
        "TSPBL"=>"Trade Shows PBL",
        "TXFRN"=>"Home Textiles and Home Furnishings",
        "WEBERP"=>"WEBERP",
        "WHATSAPP"=>"WHATSAPP",
        "WSITE"=>"WSITE",
        "Z3EBD"=>"Z3EBD",
        "ZAFRBUS"=>"ZAFRBUS",
        "ZAHI"=>"ZAHI",
        "ZALCALA"=>"ZALCALA",
        "ZALTIND"=>"ZALTIND",
        "ZAPPSRCH"=>"ZAPPSRCH",
        "ZARBET"=>"ZARBET",
        "ZATGLB"=>"ZATGLB",
        "ZB4IND"=>"ZB4IND",
        "ZBLDTRKY"=>"ZBLDTRKY",
        "ZBSYTRDE"=>"ZBSYTRDE",
        "ZDBAICHM"=>"ZDBAICHM",
        "ZDDEX"=>"ZDDEX",
        "ZDMINDON"=>"ZDMINDON",
        "ZEKERALA"=>"ZEKERALA",
        "ZENF"=>"ZENF",
        "ZFOODMCH"=>"ZFOODMCH",
        "ZFRNTRAD"=>"ZFRNTRAD",
        "ZFTASIA"=>"ZFTASIA",
        "ZGLOBAL"=>"ZGLOBAL",
        "ZGRUPOF3"=>"ZGRUPOF3",
        "ZIDEA"=>"ZIDEA",
        "ZIIFJS"=>"ZIIFJS",
        "ZIMP"=>"ZIMP",
        "ZINCNST"=>"ZINCNST",
        "ZINDASTP"=>"ZINDASTP",
        "ZINDMAAL"=>"ZINDMAAL",
        "ZINDSTK"=>"ZINDSTK",
        "ZINDSVE"=>"ZINDSVE",
        "ZINFUR"=>"ZINFUR",
        "ZJETC"=>"ZJETC",
        "ZLCHAAT"=>"ZLCHAAT",
        "ZLIVELST"=>"ZLIVELST",
        "ZMAST"=>"ZMAST",
        "ZMFINDIA"=>"ZMFINDIA",
        "ZMKTUSA"=>"ZMKTUSA",
        "ZMYCITY"=>" My City Cue",
        "ZMYTRADE"=>"ZMYTRADE",
        "ZPESCAL"=>"ZPESCAL",
        "ZPINDEX"=>"profileindex.com ",
        "ZPRINTCT"=>"ZPRINTCT",
        "ZPWEB"=>"ZPWEB",
        "ZSHWMRT"=>"ZSHWMRT",
        "ZSURAJ"=>"ZSURAJ",
        "ZTDRCHN"=>"ZTDRCHN",
        "ZTRADPLY"=>"ZTRADPLY",
        "ZTRDEB2B"=>"ZTRDEB2B",
        "ZTRDEWRD"=>"ZTRDEWRD",
        "ZTRDEXL"=>"ZTRDEXL",
        "ZTRDNMAP"=>"ZTRDNMAP",
        "ZTRDXPRO"=>"ZTRDXPRO",
        "ZTRSEAFD"=>"ZTRSEAFD",
        "ZUKWHOLE"=>"ZUKWHOLE",
        "ZWHLEUK"=>"ZWHLEUK",
        "ZWHVAC"=>"ZWHVAC",
        "ZWTRADE"=>"ZWTRADE",
        "ZYPG"=>"ZYPG"     
     );
     return $type_values;  
 }

 public static function get_delete_reasons() {           
    $type_values = array
    (
        "1"=>"Duplicate Requirement",
        "10"=>"Wrong Contact Details",
        "14"=>"Is a Supplier",
        "16"=>"IP/Country Mismatch",
        "17"=>"Test Requirement Posted",
        "21"=>"Job Enquiry",
        "25"=>"DO-NOT CALL BUYER AGAIN",
        "3"=>"Invalid Description",
        "31"=>"Banned and Adult Product",
        "48"=>"Non-Targeted leads from Procmart",
        "63"=>"No Requirement - Price Only",
        "64"=>"Calling Required",
        "65"=>"Technical Issue"
        
        );
    return $type_values;
}

public static function get_serial() { 
          
    $type_values = array
    (
        "1"=>"1",
        "3"=>"2",
        "33"=>"3",
        "19"=>"4",
        "14"=>"5",
        "21"=>"6",
        "10"=>"7",
        "29"=>"9",
        "31"=>"8",
        "7"=>"10",
        "8"=>"11",
        "17"=>"12",
        "23"=>"14",
        "34"=>"15",
        "16"=>"13"
        
        );
    return $type_values;
}

public static function get_auto_payout_reason_list() { 
            $auto_payout_reason_list=array('1'=>'Auto Payout successfully done','2'=>'KYC Not verified','3'=>'Audit - Amount Limit','4'=>'Audit - Transaction Number (4th,11th..)','5'=>'Buyer-Supplier Conflict','6'=>' Supplier as a Buyer','7'=>'Payout already done before','8'=>'Payment not accepted by Supplier','9'=>'Eligible for auto payout but not done','10'=>'Training test payment','11'=>'Auto Payout done - Late Success','12'=>'Supplier name same as Card Holder name','13'=>'Same IP more than 3 Times in 30 days','14'=>'Same Mobile more than 3 Times in 30 days','15'=>'Bank Down / Force Stop','16'=>'DB Down','17'=>'1st Audit transaction');
            return $auto_payout_reason_list;
        }	



        public static  function get_vertical()
        {
            $vertical_values=array
            (
                
                "5"=>"Marketplace",
                "9"=>"Corporate",
                "10"=>"KCD",
                "1"=>"NSD Top Cities - Inhouse FSF",
                "2"=>"CSD",
                "12"=>"Customer Operations",
                "22"=>"Tele-Monthly",
                "26"=>"Tele MDC",
                "29"=>"NSD Tele 2",
                "31"=>"NSD Tele Annual-Service",
                "38"=>"NSD ROI - Tele (Common)",
                "41"=>"TELE M ME",
                "51"=>"NSD Data Hot Lead",
                "58"=>"NSD ROI - Tele (Regional)",
                "21"=>"Enterprise Solutions",
                "28"=>"NSD Registered Supplier & Pre-Sales Support",
                "42"=>"NSD Emerging Markets - Channel FSF",
                "44"=>"NSD",
                "46"=>"CSD Value",
                "52"=>"NSD Inbound Sales",
                "20"=>"Tele-Annual",
                "45"=>"CSD Prime",
                "50"=>"NSD Sales Associate",
                "54"=>"Winback",
                "56"=>"NSD Top Cities - Channel FSF",
                "57"=>"NSD ROI - PF",
                "13"=>"NSD Top Cities - Tele (Regional)",
                "15"=>"10times",
                "17"=>"Tolexo",
                "35"=>"Tele-Monthly Welcome [TMW]",
                "36"=>"Tele-Monthly Service [TMS]",
                "37"=>"Tele-Monthly Vintage [TMV]",
                "39"=>"Medium Enterprise",
                "40"=>"Business Intelligence",
                "47"=>"NSD DSA Tele 2",
                "48"=>"NSD ROI - ME",
                "58"=>"NSD Top Cities - Tele (Common)"
                

            );

            return $vertical_values;
        }

        public static function get_designation()
        {
            $designation=array
            (
                "-1"=>"All",
                "13"=>"Trainee",
                "28"=>"Sr. Zonal Manager",
                "32"=>"Vice President",
                "14"=>"Zonal Manager",
                "2"=>"Executive",
                "3"=>"Assistant Manager",
                "4"=>"Sr. Manager",
                "7"=>"Regional Manager",
                "1"=>"Manager",
                "12"=>"Director",
                "9"=>"Pool",
                "15"=>"National Head",
                "16"=>"Branch Manager",
                "17"=>"Sr. Executive",
                "21"=>"Team Lead",
                "31"=>"Program Manager",
                "33"=>"Product Manager",
                "34"=>"General Manager",
                "35"=>"Assistant General Manager",
                "18"=>"Specialist",
                "19"=>"Relationship Manager",
                "20"=>"Business Manager",
                "22"=>"Trainee Software Programmer",
                "23"=>"Associate Software Programmer",
                "24"=>"Software Programmer",
                "25"=>"Sr. Software Programmer",
                "26"=>"Technical Lead",
                "27"=>"Project Manager",
                "29"=>"Lead Software Programmer",
                "30"=>"Sr. Regional Manager",
                "69"=>"Consultant",
                "70"=>"Senior Consultant",
                "71"=>"Business Analyst",
                "72"=>"Chief Financial Officer",
                "76"=>"Analyst Web Designer",
                "77"=>"Design Analyst",
                "80"=>"MIS Executive",
                "81"=>"Chief Information Officer",
                "85"=>"Assistant Manager QA",
                "86"=>"Senior System Engineer",
                "90"=>"test",
                "93"=>"Senior Technical Lead",
                "96"=>"Executive-Trainee",
                "99"=>"Senior Manager UX",
                "101"=>"Manager QA",
                "107"=>"Chief Operating Officer",
                "123"=>"Associate Designer",
                "128"=>"Service Providers Associate",
                "130"=>"Center Manager - Partner",
                "132"=>"Retainer",
                "133"=>"Quality Analyst Associate",
                "134"=>"Sr. Account Manager - ILP",
                "61"=>"Hardware & Network Engineer",
                "62"=>"Sr. Hardware & Network Engineer",
                "75"=>"Taxonomy Analyst",
                "82"=>"Campaign Manager",
                "83"=>"Front End Developer",
                "84"=>"Chief Product Officer",
                "92"=>"Data Analyst",
                "95"=>"Analyst",
                "102"=>"Technical Architect",
                "105"=>"Deputy CIO",
                "106"=>"Chief Executive Officer",
                "108"=>"Center Manager",
                "109"=>"Area Manager",
                "111"=>"Senior Vice President - Legal and Secretarial",
                "115"=>"Sr.Team Lead",
                "120"=>"Lead Engineer",
                "131"=>"Area Manager - Partner",
                "135"=>"Regional HR Manager",
                "63"=>"Product Marketing Manager",
                "65"=>"Sr. Web Designer",
                "74"=>"UX Designer",
                "78"=>"Test Engineer",
                "79"=>"Quality Analyst",
                "87"=>"Production Account - Executive",
                "89"=>"Chief Manager",
                "91"=>"Tolexo",
                "94"=>"Assistant Product Manager",
                "110"=>"Regional Director",
                "113"=>"Regional Admin Manager",
                "114"=>"Senior Architect",
                "119"=>"Associate Engineer",
                "122"=>"Architect",
                "125"=>"Sr.Designer",
                "129"=>"Manager - Partner",
                "36"=>"Sr. Test Engineer",
                "37"=>"Asst. Vice President",
                "38"=>"Senior Vice President",
                "39"=>"Associate test engineer",
                "40"=>"Associate Content Developer",
                "41"=>"Associate Web Designer",
                "42"=>"Web Designer",
                "43"=>"Associate",
                "44"=>"Sr. Associate",
                "45"=>"Web design Analyst",
                "46"=>"Lead Web Designer",
                "47"=>"Test Analyst",
                "48"=>"Testing Lead",
                "49"=>"Analyst Programmer",
                "50"=>"Project lead",
                "51"=>"Senior Project Manager",
                "52"=>"Senior Product Manager",
                "53"=>"Regional HR Head",
                "54"=>"Business HR Head",
                "56"=>"Sr. Content Develope",
                "57"=>"Server Administrator",
                "58"=>"Database Administrator",
                "59"=>"Sr.Server Administrator",
                "60"=>"Sr. Database Administrator",
                "64"=>"Head Call Centre-Operations",
                "66"=>"System Engineer",
                "67"=>"Company Secretary",
                "68"=>"Branch Sales Manager",
                "73"=>"Sr. Account Manager",
                "88"=>"Production Account - Manager",
                "97"=>"Senior UX Designer",
                "98"=>"Manager UX",
                "100"=>"Assistant Manager UX",
                "103"=>"Chief Human Resources Officer ",
                "104"=>"Associate DevOps",
                "112"=>"Senior Vice President - Company Secretary and Comp",
                "116"=>"Cluster Head",
                "117"=>"Engineer",
                "118"=>"Sr. Engineer",
                "121"=>"Sr. Lead Engineer",
                "124"=>"Designer",
                "126"=>"Trainer",
                "127"=>"Manager - Direct"



                            );
                            return $designation;
                        }

        public static function get_functional_area()
        {
            $functional_area=array(

            "234"=>"Product Management",
            "251"=>"Data Collection & Reporting",
            "223"=>"Cash, Branch & Personal Banking",
            "224"=>"Data & Vendor Management",
            "225"=>"Data Entry & Mapping",
            "226"=>"Support & Coordination",
            "228"=>"HR Operations",
            "229"=>"MIS",
            "230"=>"Talent Acquisition",
            "231"=>"Web Designing - Basic",
            "232"=>"Testing",
            "233"=>"Client Winback",
            "250"=>"Online Sales",
            "235"=>"Software Programming",
            "236"=>"Content Writing",
            "237"=>"Database Admin",
            "238"=>"Employee Engagement",
            "239"=>"Web Designing - Advanced",
            "240"=>"Internet Marketing - Advanced",
            "241"=>"Client Retention",
            "242"=>"Operations Management",
            "243"=>"Business Analytics",
            "244"=>"Internet Marketing - Basic",
            "245"=>"Facility & Vendor Admin",
            "246"=>"Learning & Development",
            "247"=>"Payroll & Incentives",
            "248"=>"Legal and Secretarial",
            "249"=>"Alliance, Tie-up & Barter",
            "254"=>"Client Servicing - Welcome",
            "255"=>"Client Servicing - Mix",
            "256"=>"Client Servicing - Old",
            "207"=>"Quality",
            "206"=>"Director",
            "91"=>"Customer Care",
            "92"=>"Tele Marketing",
            "96"=>"Project Delivery",
            "98"=>"Business Delivery",
            "199"=>"Network And Hardware",
            "195"=>"Corporate Communication",
            "208"=>"Trade Fairs Participation",
            "103"=>"Design Cordination",
            "121"=>"Client Acquisition",
            "122"=>"Client Servicing",
            "129"=>"Server Admin",
            "148"=>"Data Validation and Mapping",
            "252"=>"Client Hello Travel",
            "253"=>"Financial Operations, MIS & Audit",
            "275"=>"Client Servicing (CSD 2yr+)",
            "276"=>"Client Servicing (KCD)",
            "279"=>"Category Management",
            "285"=>"NACH",
            "289"=>"Client Servicing - 4M+",
            "292"=>"Content and Communication",
            "294"=>"Quality Assurance SS+",
            "305"=>"Database Management",
            "311"=>"Strategic Planning and Investor relations",
            "312"=>"Investor Relations",
            "313"=>"Financial Planning and Analysis",
            "321"=>"HR Business Partner",
            "325"=>"UX Design",
            "328"=>"Database Administration",
            "329"=>"DevOps",
            "330"=>"HTML/CSS Designing",
            "331"=>"Quality Assurance",
            "339"=>"Client Servicing Prime - ME",
            "340"=>"Client Servicing Value - Non ME",
            "259"=>"Tele sales",
            "260"=>"Client Servicing - Annual",
            "261"=>"Business Development",
            "265"=>"Business Planning and Analysis",
            "268"=>"Financial Reporting & Compliance",
            "274"=>"Technical Support",
            "278"=>"Data Acquisition And Management",
            "280"=>"Revenue Assurance",
            "287"=>"Front End Programming - Advanced",
            "298"=>"Customer On boarding",
            "299"=>"Tolexo 1",
            "301"=>"Catalog quality assurance",
            "306"=>"Information Systems Management",
            "307"=>"Machine Learning",
            "320"=>"Talent Management and Learning and Development",
            "322"=>"Cyber Security",
            "333"=>"Client Servicing MDC6",
            "334"=>"OAP-Production",
            "335"=>"OAP-Quality",
            "338"=>"Client Servicing Prime - Non ME",
            "262"=>"Product Marketing",
            "271"=>"Brand Management",
            "277"=>"Client Servicing  (CSD 1yr)",
            "283"=>"Digital Strategy",
            "286"=>"Front End Programming - Basic",
            "290"=>"Client Servicing - Vintage",
            "302"=>"Client Servicing - ME",
            "303"=>"Sales DSA",
            "304"=>"Big Data Programming",
            "318"=>"Process Design and Transformation",
            "319"=>"Talent Acquisition - Marketplace",
            "324"=>"Software Development",
            "326"=>"SQL Programming",
            "336"=>"OVP",
            "342"=>"Investment and Acquisition",
            "258"=>"Data Quality Control and Mapping",
            "270"=>"Client Servicing - Monthly",
            "272"=>"UI/UX Designing",
            "273"=>"Production",
            "284"=>"Business Delivery SS+",
            "293"=>"Web Services",
            "297"=>"Tolexo",
            "300"=>"Business strategy and transformation",
            "308"=>"Client Servicing KCD - SS+",
            "309"=>"Client Servicing KCD - ME",
            "310"=>"Client Servicing KCD - Non- ME",
            "315"=>"Business MIS",
            "316"=>"Legal and Risk",
            "317"=>"Customer Experience",
            "323"=>"Company Secretary and Compliance Officer",
            "327"=>"Data Analytics",
            "332"=>"Security",
            "337"=>"Hosting Approval",
            "341"=>"Client Servicing Value - ME"




            );
            return $functional_area;
        }
}


?>
   
