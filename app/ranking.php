<?php
$ranking = [[[],[]],[[],[]],[[],[]],[[],[]],[[],[]]];

                         // Conexão com o servidor MySQL
                        $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                    //50 borbo
                    
                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Borboleta' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[0][0][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                       //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Borboleta' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[0][1][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                                        //50 costas
                    
                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Costas' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[1][0][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                       //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Costas' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[1][1][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                                    //50 peito
                    
                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Peito' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[2][0][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                       //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Peito' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[2][1][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                                    //50 livre
                    
                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Livre' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[3][0][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                       //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Livre' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[3][1][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                                
                                //100 medley
                    
                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='100 Medley' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[4][0][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
                       //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='100 Medley' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               $ranking[4][1][] = [$row['nome_atleta'],$temp,$row['competicao'],date_format($data,"Y")];
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                       
        print(json_encode($ranking));

                        
?>
                        