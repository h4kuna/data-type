<?php declare(strict_types=1);

namespace h4kuna\DataType\Collection;

use Nette\Utils\Html;
use Nette\Utils\Json;
use Stringable;

abstract class JsonToHtml implements Stringable
{

	public function __construct(private string $_id)
	{
	}


	public function __toString(): string
	{
		return (string) $this->render();
	}


	public function render(): ?Html
	{
		$config = get_object_vars($this);
		unset($config['_id']);

		if ($config === []) {
			return null;
		}
		$el = Html::el('script', Json::encode($config));
		$el->type = 'text/json';
		$el->id = $this->_id;

		return $el;
	}

}
