#! bin/bash


echo Starting venusIT server;

basePath='/home/riyad/Dev/Projects/venusIT/';


(cd ${basePath}computer_shop_backend; code .; php artisan serve --port=8001)  &  (cd ${basePath}microcreditAndInventory_client; code .; npm run serve ) &
(cd ${basePath}microcreditAndInventory_client; npx tailwindcss -i ./src/styles/tailwind.css -o ./src/styles/dist/tailwind.css --minify -w;)



