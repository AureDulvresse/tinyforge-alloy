<?php

namespace Forge\Alloy\Contracts;

interface ModuleInterface
{
    public function up(): void;
    public function down(): void;
}
