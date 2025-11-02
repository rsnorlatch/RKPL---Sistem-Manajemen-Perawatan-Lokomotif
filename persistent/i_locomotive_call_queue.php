<?php

namespace main\persistence;

interface ILocomotiveCallQueue
{
	function call(string $locomotive_id);
}
