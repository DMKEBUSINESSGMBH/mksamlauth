# Developer Guide

## Compatibilty

As you might see, we have multiple branches. Currently we support only TYPO3 8.7 and 9.5. 
If we release a new stable release we will tag both versions.

### Reference

 * [How to create a custom enricher](./HowToEnrichers.md)

## FAQ

### Why is the configration stored in the database?

You might wonder why we choosed, to have the configuration inside the database. The reason behind this, is that we want to support multiple identity providers inside a TYPO3 instance. 
Another reason is, that so any administrator can change the settings without touching the code.