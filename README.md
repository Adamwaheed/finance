<h1>Finnance</h1>
Laravel Simple Cash Management Package

<h1>Getting Started</h1>

1.Install via  <code> composer require atolon/finance </code>

2.Add the package to your application service providers in config/app.php.

<code>
'providers' => [
  </br>
   ...
   </br>
   \Atolon\Finance\FinanceServiceProvider::class, <br>

],
</code>

3.Migrate using <code> php artisan migrate </code>