# fakeuue
Fakes Richard Marks's MS-DOS uuencode 5.21 utility

### usage
```php
$filename = 'test.txt';
$content = 'hello, world';
$uue_content = FakeUUE::encode($filename, $content);

echo $uue_content;
```
### output
```
section 1 of uuencode 5.21 of file test.txt    by R.E.M.

begin 644 test.txt
,:&5L;&\L('=O<FQD
`
end
sum -r/size 39499/43 section (from "begin" to "end")
sum -r/size 9999/12 entire input file
```
