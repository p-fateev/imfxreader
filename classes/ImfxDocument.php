<?php

/**
* 
*/
class ImfxDocument
{

	const DOC_TYPE_CLIENT_CARD = 1;
	const DOC_TYPE_GTD = 2;
	const DOC_TYPE_REESTR = 3;
	const DOC_TYPE_DMV = 6;
	const DOC_TYPE_REFUSE_CARD = 10;
	const DOC_TYPE_IMAGE = 43;
	const DOC_TYPE_ACCEPT = 61;
	const DOC_TYPE_EVAL_PROTOKOL = 62;
	const DOC_TYPE_CHECK_PROTOKOL = 64;
	const DOC_TYPE_REQUEST = 79;
	const DOC_TYPE_GTD_XPS = 80;
	const DOC_TYPE_RECALL = 81;
	const DOC_TYPE_ACCEPT_EXPORT = 82;
	
	private $_messageId;
	private $_code;
	private $_number;
	private $_fileName;
	private $_id;
	private $_rawData;	

	function __construct($messageId, $code, $number, $fileName, $rawData)
	{		
		$this->_messageId = $messageId;
		$this->_code = $code;
		$this->_number = $number;
		$this->_fileName = $fileName;
		$this->_rawData = $rawData;
		$this->_id = md5($code.$number.$fileName);
		//$this->_attachments = array();
	}

	static public function getDocTypeName($docType)
	{
		switch ($docType) {
			case self::DOC_TYPE_CLIENT_CARD: return 'Карточка учета';			
			case self::DOC_TYPE_GTD: return 'Таможенная декларация';			
			case self::DOC_TYPE_REESTR: return 'Реестр транспортных средств';			
			case self::DOC_TYPE_DMV: return 'Декларация таможенной стоимости';			
			case self::DOC_TYPE_REFUSE_CARD: return 'Карточка отказа';			
			case self::DOC_TYPE_IMAGE: return 'Сканы документа';			
			case self::DOC_TYPE_ACCEPT: return 'Подтверждение о получении';			
			case self::DOC_TYPE_EVAL_PROTOKOL: return 'Протокол обработки';			
			case self::DOC_TYPE_CHECK_PROTOKOL: return 'Протокол проверки';			
			case self::DOC_TYPE_REQUEST: return 'Запрос';			
			case self::DOC_TYPE_GTD_XPS: return 'Оформленая ГТД для печати';			
			case self::DOC_TYPE_RECALL: return 'Заявление на отзыв';			
			case self::DOC_TYPE_ACCEPT_EXPORT: return 'Подтверждение экспорта';						
		}

		return "Неизвестный тип документа (код $docType)";
	}

	public function save(IDataStorage &$storage)
	{
		$storage->saveDocument($this);
	}

	public function getMessageId()
	{
		return $this->_messageId;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getCode()
	{
		return $this->_code;
	}

	public function getFileName()
	{
		return $this->_fileName;
	}

	public function getRawData()
	{
		return $this->_rawData;
	}	

	public function __toString()
	{
		return sprintf('%s - %s', $this->_fileName, $this->_number);
	}
}