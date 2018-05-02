<?php

namespace Najaram\Zomatotoy\Exceptions;

use Exception;

class CouldNotZomatotoy extends Exception
{
	public static function noApiKey()
	{
		return new static('Must provide an api key.');
	}
	public static function couldNotConnect()
	{
		return new static('Could not connect to developers.zomato');
	}

	public static function serviceErrorReturned(string $errorMessage)
	{
		return new static('Request failed because ' . $errorMessage);
	}

	public static function emptyStringError()
	{
		return new static('Must provide the arguments.');
	}

	public static function argsError()
	{
		return new static('Must provide the required parameters.');
	}

	public static function endpointError()
	{
		return new static('Endpoint does not exists. Please check the documentation of Zomato.');
	}
}