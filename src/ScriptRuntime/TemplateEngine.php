<?php declare(strict_types=1);


namespace Shopware\Psh\ScriptRuntime;

/**
 * Replace the placeholders with there values
 */
class TemplateEngine
{
    const REGEX = '/__[A-Z,_]+__/';

    /**
     * @param string $shellCommand
     * @param ValueProvider[] $allValues
     * @return string
     */
    public function render(string $shellCommand, array $allValues): string
    {
        preg_match_all(self::REGEX, $shellCommand, $matches);
        $placeholders = $matches[0];
        
        foreach ($placeholders as $match) {
            $shellCommand = str_replace($match, $this->getValue($match, $allValues), $shellCommand);
        }

        return $shellCommand;
    }

    /**
     * @param string $placeholder
     * @param array $allValues
     * @return mixed
     */
    private function getValue(string $placeholder, array $allValues)
    {
        $valueName = substr($placeholder, 2, -2);

        foreach ($allValues as $key => $value) {
            if (strtoupper($key) == $valueName) {
                return $allValues[$key]->getValue();
            }
        }

        throw new \RuntimeException('Missing required value for "' . $valueName . '"');
    }
}
