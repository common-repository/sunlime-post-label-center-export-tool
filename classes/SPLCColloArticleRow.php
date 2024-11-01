<?php
	
	class SPLCColloArticleRow {
		public $ArticleNumber;
		public $ArticleName;
		public $Quantity;
		public $UnitID;
		public $HSTariffNumber;
		public $CountryOfOriginID;
		public $ValueOfGoodsPerUnit;
		public $CurrencyID;
		public $ConsumerUnitNetWeight;
		public $CustomsOptionID;
		
		public function __construct( $article_number, $articleName, $quantity, $unit_id, $hs_tariff_number, $country_of_origin_id, $value_of_goods_per_unit, $currency_id, $consumer_unit_net_weight, $customs_option_id ) {
			$this->ArticleNumber         = $article_number;
			$this->ArticleName           = $articleName;
			$this->Quantity              = $quantity;
			$this->UnitID                = $unit_id;
			$this->HSTariffNumber        = $hs_tariff_number;
			$this->CountryOfOriginID     = $country_of_origin_id;
			$this->ValueOfGoodsPerUnit   = $value_of_goods_per_unit;
			$this->CurrencyID            = $currency_id;
			$this->ConsumerUnitNetWeight = $consumer_unit_net_weight;
			$this->CustomsOptionID       = $customs_option_id;
		}
	}