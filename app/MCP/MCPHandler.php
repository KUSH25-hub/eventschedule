<?php

namespace App\MCP;

class MCPHandler
{
    protected array $tools = [];

    /**
     * Register an MCP tool.
     */
    public function tool(string $name, callable $callback): void
    {
        $this->tools[$name] = $callback;
    }

    /**
     * Call a registered MCP tool.
     */
    public function callTool(string $name, mixed $input): mixed
    {
        if (!isset($this->tools[$name])) {
            throw new \InvalidArgumentException("Tool '{$name}' not found.");
        }

        return call_user_func($this->tools[$name], $input);
    }

    /**
     * Get all registered tools (optional, for debugging).
     */
    public function getTools(): array
    {
        return $this->tools;
    }
}
