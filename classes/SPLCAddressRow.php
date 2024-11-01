<?php
	
	class SPLCAddressRow {
		public $Name1;
		public $Name2;
		public $AddressLine1;
		public $PostalCode;
		public $CountryID;
		public $City;
		public $Tel1;
		public $Email;
		
		public function __construct( $name1, $address_line_1, $housenumber, $postal_code, $country_id, $city, $tel1 = '', $email = '', $name2 = '' ) {
			$this->Name1        = $name1;
			$this->AddressLine1 = $address_line_1;
			$this->HouseNumber  = $housenumber;
			$this->PostalCode   = $postal_code;
			$this->CountryID    = $country_id;
			$this->City         = $city;
			$this->Tel1         = $tel1;
			$this->Email        = $email;
			$this->Name2        = $name2;
		}
	}