# Setting for Laravel

*:loudspeaker: NOTE:* My English is not very good, I sincerely apologize if it inconveniences you.

Setting for Laravel is a library designed to provide easy management of settings for Laravel applications. It allows you
to handle and override Laravel configurations with ease.

### Installation

You can install the Setting for Laravel library via Composer. Run the following command in your terminal:

```bash
composer require ducconit/laravel-setting
```

### Usage

- After installing the library, you need to publish the configuration file. Run the following Artisan command:

```bash
php artisan vendor:publish --provider="DNT\Setting\SettingServiceProvider" --tag="config"
```

- Once the configuration file is published, you can find it at `config/setting.php`. This is where you can define your
  settings.
- To access the settings, you can use the Setting facade. Import the facade at the top of your file:

```php
use DNT\Setting\Facade;
```

#### 1. Retrieving Settings

- You can retrieve all the settings using the all method:

```php
// helper function
setting()->all();

// facade
Facade::all();
```

- Or a specific setting using the get method:

```php
// helper function
setting()->get('key', $default);
setting('key', $default);

// facade
Facade::get('key', $default);
```

#### 2. Updating Settings

- You can also set a new value for a setting using the set method:

```php
// helper function
setting()->set('key', $value);

// facade
Facade::set('key', $value);
```

- You can also update multiple settings at once by passing an array of key-value pairs:

```php
// helper function
use DNT\Setting\Facade;setting()->set([
    'key' => $value,
    'other_key' => $other_value
]);
setting([
    'key' => $value,
    'other_key' => $other_value
]);

// facade
Facade::set([
    'key' => $value,
    'other_key' => $other_value
]);
```

#### 3. Deleting Settings

- To delete a setting, you can use the forget method:

```php
// helper function
use DNT\Setting\Facade;setting()->forget('key');

// facade
Facade::forget('key');
```

- You can also delete multiple settings at once by passing an array of keys:

```php
// helper function
use DNT\Setting\Facade;setting()->forget(['key', 'other_key']);

// facade
Facade::forget(['key', 'other_key']);
```

#### 4. Saving Settings

- After making changes to the settings, you need to save them using the save method:

```php
// helper function
setting()->save();

// facade
Facade::save();
```

- The save method will only save the settings if there are any changes. It returns an array of the updated settings with
  their "old" and "new" values.

#### 5. Retrieving Changed Settings

- You can get the array of changed settings with their "old" and "new" values using the changed method:

```php
// helper function
setting()->changed();

// facade
Facade::changed();
```

Please note that the changed method will only include the settings that have been added, modified, or deleted since the
last save.

- You can use the isChanged method to check if any settings have been added, modified, or deleted:

```php
// helper function
setting()->isChanged();

// facade
Facade::isChanged();
```

The isChanged method returns a boolean value indicating whether any changes have been made to the settings.

#### 6. Exception Handling

The library throws the following exceptions:

- JsonException: Thrown when there is an error in decoding or encoding JSON.
- UnreadableException: Thrown when the storage file is unreadable, for example, when unable to read the file at
  storage/app/setting.json.
- UnwritableException: Thrown when the storage file is unwritable, for example, when unable to write to the file at
  storage/app/setting.json.
- SaveSettingException: Thrown when there is an error in saving the settings.

You can handle these exceptions in your application to provide custom error handling or debugging.

### Testing

```php
composer test
```

### Contributing

Contributions are welcome! If you find any issues or want to contribute to this library, please open an issue or submit
a pull request on the GitHub repository.

### License

This library is open-source software licensed under the MIT license.
