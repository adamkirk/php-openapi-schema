# Limitations

This library is intentionally very basic, and doesn't support a lot of potentially useful functionality.

## PHP Versions

It supports PHP `>= 8.0` (also in `composer.json`). I wanted to support earlier versions, but due to how I use [static return types](https://wiki.php.net/rfc/static_return_type){target=blank} for some of the abstract classes, it was not really do-able to go any lower (without sacrificing some type-safety which is handy).

## Open API Schema versions

Currently this is only tested with [OpenAPI Specification 3.1.0](https://spec.openapis.org/oas/v3.1.0.html){target=blank}. I think it may be possible to use it in it's current state to support other versions, by using custom attributes *very liberally*.

## Validation

This library doesn't perform any validation of the spec itself; either as you build (i.e. `setPathItem(...)`) or at the point of marshalling the document. The choice was to keep this very simple and allow this to happen at another layer in the stack. Rather than perform validation at the point of object instantiation/modification it seems to make more sense to let the user build this however they like and if it's invalid at stages throughout the process that's fine. But by the end the entire document van be validated against a json schmea using something like [opi/json-schema](https://github.com/opis/json-schema){target=blank}.

## Generating schemas automatically

This library is supposed just be the building block, it doesn't automatically build schemas from framework routers, annotations, attributes etc. It can be used by such generators to build the underlying data structures they need.

*This was the prime motivation for building this, as I wanted to build a library to generate api schemas from code.*

*[< Back](../)*