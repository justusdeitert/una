// stylelint Configuration File
module.exports = {
  'extends': 'stylelint-config-standard',
  'defaultSeverity': 'warning',
  'rules': {
    "indentation": [4, {
      "severity": "warning"
    }],
    "color-hex-case": ['upper', {
      "severity": "warning"
    }],
    "no-descending-specificity": null,
    'no-empty-source': null,
    'at-rule-no-unknown': [true, {
      'ignoreAtRules': [
        'extend',
        'at-root',
        'debug',
        'warn',
        'error',
        'if',
        'else',
        'for',
        'each',
        'while',
        'mixin',
        'include',
        'content',
        'return',
        'function',
        'function-comma-space-before'
      ]
    }],
    'selector-list-comma-newline-after': 'always-multi-line',
    'selector-pseudo-element-colon-notation': 'single',
    // https://stylelint.io/user-guide/rules/function-comma-space-before/
    // ------------------------>
    // string: "always"|"never"|"always-single-line"|"never-single-line"
    // 'function-comma-space-after': 'never'
  }
};
