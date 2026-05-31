# Code Standards - VNCT Laravel Application

## PHP/Laravel Standards

### General PHP Guidelines

- PHP 7.3+ / 8.0 compatibility
- PSR-4 autoloading standard
- Use type hints where possible
- DocBlocks for complex methods

### File Naming

| Type | Convention | Example |
|------|------------|---------|
| Models | PascalCase | `User.php`, `Terms.php` |
| Controllers | PascalCase | `PagesController.php` |
| Middleware | PascalCase | `Auth_admin.php` |
| Config files | snake_case | `ckfinder.php`, `jetstream.php` |
| Migrations | snake_case with timestamp | `2024_01_01_000000_create_users.php` |
| Helpers | PascalCase | `Helper.php`, `FrontEnd.php` |
| Views | snake_case.blade.php | `home.blade.php` |

### Code Organization

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── admin/           # Admin controllers
│   │   ├── Api/             # API controllers
│   │   ├── Auth/            # Jetstream auth
│   │   └── *.php            # Frontend controllers
│   ├── Lib/                 # Business logic classes
│   │   ├── Order_lib.php    # Order processing
│   │   ├── Product_lib.php  # Product operations
│   │   ├── Coupon_lib.php   # Coupon handling
│   │   └── Terms_lib.php    # Taxonomy operations
│   ├── Livewire/            # Livewire components
│   ├── Middleware/          # Custom middleware
│   └── Requests/            # Form requests
├── Models/                  # Eloquent models
├── Helpers/                  # Helper classes
└── Providers/               # Service providers
```

### Controller Standards

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terms;
use App\Helpers\Helper;
use App\Http\Lib\Order_lib;

class PagesController extends Controller
{
    // Dependency injection in constructor
    protected $orderLib;

    public function __construct(Order_lib $orderLib)
    {
        $this->orderLib = $orderLib;
    }

    // Method naming: verb + noun
    public function getindex() { }
    public function trangchitiet($slug) { }
    public function trangloai($slug, Request $request) { }
}
```

### Lib Classes Pattern

Business logic that does not fit in models or controllers should be extracted to `App\Http\Lib\` classes.

```php
<?php

namespace App\Http\Lib;

use App\Models\Order;
use App\Models\order_product;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class Order_lib
{
    // Single responsibility: order creation from cart
    public function insert($request, $cart)
    {
        // Create or find user
        // Generate order code
        // Apply coupons
        // Create order + order_product records
    }

    // Another method for different business operation
    public function cancel($orderId)
    {
        // Cancel order logic
    }
}
```

**When to use Lib classes:**
- Complex business logic spanning multiple models
- Cart-to-order conversion workflows
- Coupon validation and application logic
- Tax/shipping calculations

**Note:** The `bumbummen99/shoppingcart` package (v4.0) may be abandoned. Consider alternatives if issues arise.

### Livewire Component Standards

Livewire components go in `App\Http\Livewire\` and extend `Controller` or package base classes.

```php
<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class OrdersTable extends LivewireDatatable
{
    public $model = Order::class;

    public function builder()
    {
        return Order::where('users_id', auth()->id());
    }

    public function columns()
    {
        return [
            Column::name('CodeOrder')->searchable(),
            Column::callback('Total', fn($value) => $value . '$')->label('Total'),
        ];
    }
}
```

### Model Standards

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\where_language;

class Posts extends Model
{
    use HasFactory;

    // Table name if not following convention
    protected $table = 'posts';

    // Fillable fields for mass assignment
    protected $fillable = [
        'Post_Title',
        'Post_Name',
        'Post_Content',
        'lang',
        'origin_id',
    ];

    // Relationships with clear naming
    public function Terms()
    {
        return $this->belongsToMany('App\Models\Terms', 'terms_posts');
    }

    // Scopes for query filtering
    public function scopeOrderbyFilter($query, $request)
    {
        // ...
    }

    // Route model binding without global scope
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withoutGlobalScope(\App\Scopes\where_language::class)
                    ->where($field ?? $this->getRouteKeyName(), $value)
                    ->first();
    }

    // Boot method for global scopes
    protected static function booted()
    {
        static::addGlobalScope(new where_language());
    }
}
```

### Route Standards

```php
// web.php - Group routes by prefix/namespace

// Admin routes
Route::prefix('admin')->group(function () {
    Route::middleware(Auth_admin::class)->group(function () {
        Route::get('', [PageController::class, 'index'])->name('main_admin');

        // Resource routes
        Route::resource('members', MemberController::class);

        // Nested routes
        Route::get('members/copy-lang/{lang}/{member}', [MemberController::class, 'copyLang']);
    });
});

// Business routes
Route::prefix('business')->name('business.')->group(function () {
    Route::get('/login', [BusinessAuthController::class, 'showForm'])->name('login.form');
    Route::post('/register', [BusinessAuthController::class, 'register'])->name('register');
});

// Cart routes
Route::prefix('carts')->group(function () {
    Route::post('', [CartController::class, 'carts']);
    Route::post('removebyid', [CartController::class, 'removebyid']);
});
```

### View Standards

- Blade templates with `.blade.php` extension
- Lowercase with underscores for partials: `header.blade.php`
- Lowercase with hyphens for components: `post-card.blade.php`
- Store in `resources/views/` with directory organization

### Database Standards

- Use Eloquent ORM for data access
- Define relationships explicitly
- Use migration files for schema changes
- Foreign keys for referential integrity

### Migration Naming

```
YYYY_MM_DD_HHMMSS_create_table_name.php
2024_01_15_100000_create_posts_table.php
```

### Multilingual Implementation

```php
// Model with language global scope
protected static function booted()
{
    static::addGlobalScope(new where_language());
}

// Route for language switching
Route::get('language/{lang}', function ($lang) {
    $id = language::where("Name", $lang)->first();
    App::setLocale($id->id);
    Session::put('language', $id->id);
    return redirect()->back();
});

// Origin-based translation query
$translated = DB::table('posts')
    ->where('lang', $langId)
    ->where(function($q) use ($oid) {
        $q->where('id', $oid)->orWhere('origin_id', $oid);
    })->first();
```

### Middleware Standards

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth_admin
{
    public function handle(Request $request, Closure $next)
    {
        // Check admin session
        if (!Session::has('admin')) {
            return redirect()->route('login_admin');
        }
        return $next($request);
    }
}
```

### Form Request Standards

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Post_Title' => 'required|string|max:255',
            'Post_Content' => 'required',
            'Price' => 'nullable|numeric',
        ];
    }
}
```

### E-commerce Patterns

```php
// Cart usage
use Gloudemans\Shoppingcart\Facades\Cart;

Cart::add($id, $name, $qty, $price);
Cart::content();
Cart::total();
Cart::instance('cart')->destroy();

// Order creation
$order = Order::create([
    'CodeOrder' => $code,
    'users_id' => Auth::id(),
    'total' => Cart::total(),
    'status' => 1,
]);

// Coupon validation
$coupon = Coupon::where('code', $code)->first();
if ($coupon && $coupon->limit > 0) {
    // Apply discount
}
```

### Security Standards

- Password hashing: `bcrypt()` or `Hash::make()`
- CSRF protection on all forms (Laravel default)
- Input validation via Form Request
- SQL injection prevention via Eloquent ORM
- XSS prevention via Blade escaping

### Admin Auth Pattern

```php
// Custom admin auth (separate from Jetstream)
Route::post('checklogin', [PageController::class, 'checklogin']);

// Middleware check
if (!Session::has('admin')) {
    return redirect()->route('login_admin');
}

// Admin logout
Route::get('logout', function () {
    Session::flush();
    Auth::logout();
    return redirect()->route('login_admin');
});
```

### Configuration Standards

- Environment-based config via `.env`
- Config files in `config/` directory
- Use `config()` helper for access
- CKFinder config at `config/ckfinder.php`

### Error Handling

```php
try {
    // Code that may throw
} catch (\Exception $e) {
    Log::error($e->getMessage());
    return back()->with('error', 'Something went wrong');
}
```

### Logging

```php
use Illuminate\Support\Facades\Log;

Log::info('User action', ['user_id' => $id, 'action' => 'create']);
Log::error('Error occurred', ['exception' => $e]);
```

### Testing Standards

- PHPUnit for unit tests
- Test feature methods: `testMethodName`
- Use factories for test data
- Test auth, validation, and business logic

### API Response Standards

```php
// JSON responses
return response()->json([
    'results' => $data,
    'pagination' => ['more' => false]
]);

// Error responses
return response()->json(['error' => 'Not found'], 404);
```

## File Size Limits

- **Controllers:** Keep under 500 lines; split large controllers
- **Models:** Keep under 200 lines; extract complex logic to repositories
- **Views:** Keep under 300 lines; use Blade components
- **Config files:** Keep under 200 lines

## Code Review Checklist

- [ ] Type hints used on function parameters and return values
- [ ] Relationships defined on models
- [ ] Fillable fields specified for mass assignment
- [ ] Global scopes documented
- [ ] Routes named for reverse lookup
- [ ] Form requests used for validation
- [ ] CSRF protection on forms
- [ ] Error handling with try-catch where needed
- [ ] No hardcoded values; use config/env
- [ ] Queries use Eloquent ORM
- [ ] Code is self-documenting with clear naming