#INSTALLATION

#DATABASE

For this small project, the username and password use for the database are 'root' and 'root'
If yours may differ, please change the line 26 in AppBundle\Service\Database accordingly

You will have to dump the database contained in test.sql. To do that, run the following command:

``` mysql -u <username> -p -h localhost test < test.sql ```

#Launching

Simply run:

``` php bin/console server:run ```

