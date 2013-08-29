<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MCPHP -- a light-weight php framework</title>
</head>
<body>

<h2>{%$say%}</h2>

<h3>1. common config:</h3>
{%if !empty($common_config)%}
<ul>
{%foreach $common_config as $key => $item%}
    <li><b>{%$key%}: </b>{%$item%}</li> 
{%/foreach%}
</ul>
{%/if%}

<h3>2. config: </h3>
{%if !empty($config)%}
<ul>
{%foreach $config as $key => $item%}
    <li>
        <h3>{%$key%}</h3>
        <ol>
    {%foreach $item as $key1 => $item1%}
    <li><b>{%$key1%}: </b>{%$item1%}</li> 
    {%/foreach%}
        </ol>
    </li>
{%/foreach%}
</ul>
{%/if%}

</body>
</html>


