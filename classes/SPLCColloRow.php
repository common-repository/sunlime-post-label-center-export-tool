<?php
	
	class SPLCColloRow {
		public $Weight;
		public $Length;
		public $Width;
		public $Height;
		public $ColloArticleList;
		
		public function __construct( $collo_article_list, $weight = 0, $length = 0, $width = 0, $height = 0 ) {
			$this->Weight           = $weight;
			$this->Length           = $length;
			$this->Width            = $width;
			$this->Height           = $height;
			$this->ColloArticleList = $collo_article_list;
		}
	}