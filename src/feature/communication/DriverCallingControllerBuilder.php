<?php

namespace lms\feature\communication;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\persistence\InMemoryAcceptedCallRepository;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;
use lms\feature\communication\persistence\InMemoryRejectedCallRepository;
use lms\feature\communication\persistence\MySqlConfirmationFinishRepository;
use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\communication\persistence\MySqlConfirmationProblemRepository;
use lms\feature\communication\persistence\MySqlAcceptedCallRepository;
use lms\feature\locomotive_management\persistence\MySqlOnSiteLocomotiveRepository;
use lms\feature\communication\persistence\MySqlRejectedCallRepository;

use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;


class DriverCallingControllerBuilder
{
    private $_calls = [];
    private $_confirmationFinishes = [];
    private $_confirmationProblems = [];
    private $_acceptedCalls = [];
    private $_rejectedCalls = [];
    private $_onSiteLocomotives = [];

    public function populate_call($data)
    {
        $this->_calls = $data;

        return $this;
    }
    public function populate_confirmation_finishes($data)
    {
        $this->_confirmationFinishes = $data;

        return $this;
    }
    public function populate_confirmation_problems($data)
    {
        $this->_confirmationProblems = $data;

        return $this;
    }
    public function populate_accepted_calls($data)
    {
        $this->_acceptedCalls = $data;

        return $this;
    }
    public function populate_rejected_calls($data)
    {
        $this->_rejectedCalls = $data;

        return $this;
    }
    public function populate_on_site_locomotives($data)
    {
        $this->_onSiteLocomotives = $data;

        return $this;
    }

    public function build_fake()
    {
        return new DriverCallingController(
            new InMemoryCallRepository($this->_calls),
            new InMemoryConfirmationFinishRepository($this->_confirmationFinishes),
            new InMemoryConfirmationProblemRepository($this->_confirmationProblems),
            new InMemoryAcceptedCallRepository($this->_acceptedCalls),
            new InMemoryRejectedCallRepository($this->_rejectedCalls),
            new InMemoryOnSiteLocomotiveRepository($this->_onSiteLocomotives)
        );
    }

    public function build($db)
    {
        return new DriverCallingController(
            new MySqlCallRepository($db),
            new MySqlConfirmationFinishRepository($db),
            new MySqlConfirmationProblemRepository($db),
            new MySqlAcceptedCallRepository($db),
            new MySqlRejectedCallRepository($db),
            new MySqlOnSiteLocomotiveRepository($db)
        );
    }
}
