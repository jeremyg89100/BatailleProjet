<?php

    class Bateau {
        public int $id;
        public string $name;
        public int $size;

        public function __construct(int $id, string $name, int $size) {
            $this->id = $id;
            $this->name = $name;
            $this->size = $size;
        }
    }