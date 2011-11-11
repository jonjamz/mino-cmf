<?php $type = "businesses"; require_once __DIR__."/model.wrapper.php"; class businesses { 


		// Properties
		
		private $db;
		
		//--> Put model properties here.
		
		
	// Methods

  function __construct($type) { $this->db = new db($type); }

	//--> Put model methods here. Call them from your view with get(method) and give them a div with data-model=method attribute to spill into.


} ?>