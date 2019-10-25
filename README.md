# Checking

Add to you composer.json

```json
"scripts": {
    "post-install-cmd": [
        "N3ttech\\Checking\\ScriptHandler::createCopy"
    ],
    "post-update-cmd": [
        "N3ttech\\Checking\\ScriptHandler::createCopy"
    ]
}
```