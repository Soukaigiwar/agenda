<?php

class CustomException extends Exception {
    public function errorMessage() {
      return $this->getMessage();
    }
  }
