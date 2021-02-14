#Kurulum

`composer install`

#Tabloların ve Dataların Oluşturulması

`php artisan migrate`

`php artisan db:seed --class=ProviderSeeder`

`php artisan db:seed --class=UserSeeder`

#Console Komutları
Providerların içeri import edilmesi

`php artisan task:import` 

Taskların Developerlara paylaştırılması

`php artisan task:distribution`

#Oluşturulan dataların viewda gösterilmesi

`php artisan key:generate`

`php artisan serve`

