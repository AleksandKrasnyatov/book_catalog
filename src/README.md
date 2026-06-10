# Example Full: layered Yii2 book catalog

This folder is a full reference rewrite of the original `master` project into a 3-layer architecture.

It is intentionally isolated under the `ExampleFull` namespace and is not wired into the current application. Use it as a target design when refactoring the real `src` code.

## Scope

Covered original features:

- author CRUD;
- book CRUD;
- book-author synchronization;
- book photo upload and URL generation;
- public subscription to author notifications;
- top authors report;
- new-book SMS notification through queue job;
- login form as HTTP/auth infrastructure;
- Yii2 controllers/actions/forms/views style;
- ActiveRecord persistence isolated in infrastructure.

## Dependency Rule

```text
Infrastructure -> Application -> Domain
```

Domain has no Yii, ActiveRecord, HTTP, filesystem, queue, SMSPilot, views or global `Yii::$app`.

Application contains use cases, ports, query models and commands. It depends on Domain only.

Infrastructure contains Yii action classes, forms, ActiveRecord records, mappers, repositories, queue jobs, storage and SMS adapters.

## Structure

```text
example-full/
  Domain/
    Entity/
    ValueObject/
    Exception/
  Application/
    Command/
    Query/
    Port/
    DTO/
  Infrastructure/
    Http/
      Action/
      Controller/
      Form/
      View/
    Persistence/
      ActiveRecord/
      Mapper/
      Repository/
    Queue/
    Sms/
    Storage/
    Yii/
```

## Main Differences From Original Code

- `BookForm` validates uploaded file input but never saves files.
- `Book` stores `PhotoName`, not file paths and not URLs.
- `PhotoUrlGenerator` builds URLs for views in Infrastructure.
- `SendNewBookSmsJob` delegates to an Application use case.
- `SubscriptionForm` validates phone format only; existence checks move to `SubscribeToAuthorHandler`.
- Search/report SQL lives in query repositories, not forms.
- ActiveRecord classes are infrastructure records, not Domain entities.

