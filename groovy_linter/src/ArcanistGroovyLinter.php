<?php
final class ArcanistCodeNarcLinter extends ArcanistExternalLinter {

  public function getInfoName() {
    return 'NpmGroovyLint';
  }

  public function getInfoURI() {
    return 'https://github.com/nvuillam/npm-groovy-lint/';
  }

  public function getInfoDescription() {
    return pht('Lint, format and auto-fix your Groovy / Jenkinsfile / Gradle files using command line');
  }

  public function getLinterName() {
    return 'groovy';
  }

  public function getLinterConfigurationName() {
    return 'groovy';
  }

  public function getDefaultBinary() {
    return 'npm-groovy-lint';
  }

  public function getInstallInstructions() {
    return pht('Install npm-groovy-lint running `%s` (nodejs 12+ required)', 'npm install -g npm-groovy-lint');
  }

  public function getMandatoryFlags() {
    $options = array();

    $options[] = '--output=json';
    $options[] = '--no-insight';
    $options[] = '--rulesets=' . dirname(__FILE__) . '/../ruleset.groovy';
    $options[] = '--files';

    return $options;
  }

  protected function parseLinterOutput($path, $err, $stdout, $stderr) {
    $json = json_decode($stdout, true);
    $files = $json['files'];

    $messages = array();

    $severityMap = array();
    $severityMap['info'] = ArcanistLintSeverity::SEVERITY_ADVICE;
    $severityMap['warning'] = ArcanistLintSeverity::SEVERITY_WARNING;
    $severityMap['error'] = ArcanistLintSeverity::SEVERITY_ERROR;
    $severityMap['off'] = ArcanistLintSeverity::SEVERITY_DISABLED;

    foreach ($files as $file => $value) {
      $errors = $value['errors'];

      foreach($errors as $error) {
        $message = new ArcanistLintMessage();
        $message->setPath($file);
        $message->setLine($error['line']);
        $message->setCode('Groovy');
        $message->setName($error['rule']);
        $message->setDescription($error['msg']);
        $message->setseverity($severityMap[$error['severity']]);

        $messages[] = $message;
      }
    }

    return $messages;
  }
}
