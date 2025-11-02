<?php

namespace main\domain;

interface ILocomotiveRepository
{
	function get_by_id(string $locomotive_id);
}
