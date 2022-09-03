<?php
        $datafile = '/tmp/MonoInverter.json';
        $dataroot = '/tmp/MonoInverter';

        if (!file_exists($dataroot))
                if (!mkdir($dataroot))
                {
                        echo "Failed to create $dataroot\n";
                        exit;
                }

        // Get fresh data?
        shell_exec("cd /mnt/dietpi_userdata/MonoInverter; mono ./MonoInverter.exe > $datafile");

        if (file_exists($datafile))
        {
                if ($data = @json_decode(file_get_contents($datafile)))
                {
                        foreach ((array)$data AS $i => $v)
                        {
                                echo "$i => $v\n";
                                file_put_contents($dataroot.'/'.$i, $v);
                        }
                        echo "\n";
                } else
                        echo "Invalid json data found in $datafile\n";
        } else
                echo "No json data found in $datafile\n";
