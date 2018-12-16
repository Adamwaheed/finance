#Finnance
Laravel Simple Cash Management Package

#Getting Started

1.Install via  <code> composer require atolon/finance </code>

2.Add the package to your application service providers in config/app.php.

<code>
'providers' => [
   ...
   \Atolon\Finance\FinanceServiceProvider::class,

],
</code>

3.Migrate using <code> php artisan migrate </code>