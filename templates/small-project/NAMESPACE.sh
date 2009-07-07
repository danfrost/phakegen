echo "Starting <?= $this->namespace ?> by <?= $this->author ?>"

echo
dir=`dirname $0`

file=$dir"/app/lib/Bootstrap.php "$*

php -d display_errors=On $file

echo "done!";