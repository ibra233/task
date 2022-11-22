# Laravel Task
## Kurulum

Projeyi klonlayın.

```

git clone https://github.com/ibra233/task.git
```

Proje klasörünün içine girin

```
cd ./task
```
Projeyi kurun 

```
composer install
```
.env dosyasını kopyalayın
```
cp .env.example .env
```

Yeni uygulama anahtarı oluşturun 

```
php artisan key:generate
```

Veritabanı oluşturduktan sonra migration'ları çalıştırın 

```
php artisan migrate
```

Veritabanını tohumlayın 

```
php artisan db:seed
```

Mail gönderiminin çalışması için .env dosyasında alttaki satırları ayarlamanız gerekmektedir.
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
