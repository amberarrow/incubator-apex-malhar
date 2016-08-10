File Input Operator
=============

## Operator Objective
This operator scans a directory for files. Files are then read and split into tuples based on your logic e.g. tuple can be a line  or a block from file, which are then emitted. The operator can be used with different file systems like HDFS, S3, ftp, nfs etc provided hadoop supports that file system.

The default [DirectoryScanner](#https://datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.DirectoryScanner.html) polls a input directory for files. You can provide regular expression to scanner to select perticular files from directory. The scanner maintains a list of alredy scanned files, so only newly added files will be read on next poll of directory. The modified or deleted files will not be considered during scan.

The operator is fault tolerant. It tracks previously read files and current offset as part of checkpoint state. In case of failure the operator will skip files that were already processed and fast forward to the offset of the current file. Supports both static and dynamic partitioning. For static partitioning it also accpets changes to number of partitions at run time. The directory scanner is responsible to only accept the files that belong to a partition.
## Partitioning of File Input Operator
#### Static Partitioning of File Input Operator
Configure parameter "partitionCount" to define desired number of static partitions.

```xml
  <property>
    <name>dt.operator.{OperatorName}.prop.partitionCount</name>
    <value>4</value>
  </property>
```

where {OperatorName} is the name of the input operator.
Above lines will partition operator statically 4 times. Above value can be changed accordingly to change the number of static partitions.

#### Dynamic Partitioning of File Input Operator
Override ```getNewPartitionCount()``` method to do dymanic partitioning.

File Input Operator is **idempotent**, **fault-tolerant** and **partitionable**.

## Operator Usecase
1. Read all files of a directory and then keep scanning it for newly added files.

## Operator Information
1. Operator location: ***malhar-library***
2. Available since: ***1.0.2***
3. Operator state: ***Stable***
3. Java Packages:
    * Operator: ***[com.datatorrent.lib.io.fs.AbstractFileInputOperator](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html)***

### AbstractFileInputOperator
This is the abstract implementation that serves as base class for scanning a directory for files and read the files one by one. The default implementation scans a single directory, you can extend this class to override scanner to work with multiple input directories. [This](#https://github.com/DataTorrent/examples/tree/master/tutorials/fileIO-multiDir) example in datatorrent examples repository demostrates how to do that. This class doesn’t have any ports.

![AbstractFileInputOperator.png](images/fsInput/operatorsClassDiagram.png)

## Properties and Ports
### <a name="AbstractFileInputOperatorProps"></a>Properties of AbstractFileInputOperator
| **Property** | **Description** | **Type** | **Mandatory** | **Default Value** |
| -------- | ----------- | ---- | ------------------ | ------------- |
| *directory* | absolute path of directory to be scanned | String | Yes | N/A |
| *scanIntervalMillis* | Interval in milliseconds after which directory should be scanned for new files | int | No | 5000 |
| *emitBatchSize* | Number of tuples to emit in a batch. Batch is collection of tuples bundled together. Multiple of such batches will be emitted in a window. | int | No | 1000 |
| *partitionCount* | Desired number of partitions count | int | No | 1 |
| *maxRetryCount* | Maximum number of times the operator will attempt to process a file | int |No | 5 |
| *scanner* | Scanner to scan new files in directory | [DirectoryScanner](#DirectoryScanner) | No | DirectoryScanner |

#### <a name="DirectoryScanner"></a>Properties of DirectoryScanner
| **Property** | **Description** | **Type** | **Mandatory** | **Default Value** |
| -------- | ----------- | ---- | ------------------ | ------------- |
| *filePatternRegexp* | regex to select files from input directory | String | No | N/A |

### Ports
This operator has no ports.

## Abstract Methods
void emit(T tuple): Abstract method that emits tuple read from file.

T readEntity(): Abstract method to read file entity (can be a line or block).

## Derived Classes
### 1. AbstractFTPInputOperator
The class is used to read files from FTP file system. Derived class need to implement [readEntity()](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html#readEntity()) and [emit(T)](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html#emit(T)) methods.
#### Properties and Ports
#### <a name="AbstractFTPInputOperatorProps"></a>Properties of AbstractFTPInputOperator
| **Property** | **Description** | **Type** | **Mandatory** | **Default Value** |
| -------- | ----------- | ---- | ------------------ | ------------- |
| *host*| Hostname of ftp server.| String | Yes | N/A |
| *port*| Port of ftp server.| int | No | 21 (default ftp port) |
| *userName*| Username which is used for login to the server. | String | No | anonymous |
| *password*| Password which is used for login to the server. | String | No | gues |

#### Ports
This operator has no ports.

### 2. AbstractParquetFileReader
Reads Parquet files from input directory using GroupReadSupport. Derived classes need to implement [convertGroup(Group)](https://www.datatorrent.com/docs/apidocs/com/datatorrent/contrib/parquet/AbstractParquetFileReader.html#convertGroup(Group)) method to convert Group to other type. Also it should implement  [readEntity()](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html#readEntity()) and [emit(T)](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html#emit(T)) methods.

#### Properties and Ports
#### <a name="AbstractParquetFileReaderProps"></a>Properties of AbstractParquetFileReader
| **Property** | **Description** | **Type** | **Mandatory** | **Default Value** |
| -------- | ----------- | ---- | ------------------ | ------------- |
| *parquetSchema*| Parquet Schema to parse record. | String | Yes | N/A |

#### Ports
This operator has no ports.

### 3. AbstractThroughputFileInputOperator
This operator provides dynamic partitioning to AbstractFileInputOperator. The user can set the preferred number of pending files per operator as well as the max number of operators and define a repartition interval. If a physical operator runs out of files to process and an amount of time greater than or equal to the repartition interval has passed then a new number of operators are created to accommodate the remaining pending files. Derived classes need to implement [readEntity()](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html#readEntity()) and [emit(T)](https://www.datatorrent.com/docs/apidocs/com/datatorrent/lib/io/fs/AbstractFileInputOperator.html#emit(T)) methods.

#### Properties and Ports
#### <a name="AbstractThroughputFileInputOperatorProps"></a>Properties of AbstractThroughputFileInputOperator
| **Property** | **Description** | **Type** | **Mandatory** | **Default Value** |
| -------- | ----------- | ---- | ------------------ | ------------- |
| *repartitionInterval*| The minimum amount of time that must pass in milliseconds before the operator can be repartitioned. | long | No | 5 minutes |
| *preferredMaxPendingFilesPerOperator* | the preferred number of pending files per operator. | int | No | 10 |
| *partitionCount* | the maximum number of partitions for the operator. | int | No | 1 |

#### Ports
This operator has no ports.

### 4. LineByLineFileInputOperator
The operator read contents of a file line by line. Each line is emitted as a separate tuple in string format.

#### Properties and Ports
#### Prooperties
This operator has no added properties. Refer [parent class](#AbstractFileInputOperatorProps) properties for more details.

#### Ports
| **Port** | **Description** | **Type** | **Mandatory** |
| -------- | ----------- | ---- | ------------------ |
| *output* | Tuples that are read from file are emitted on this port | String | No |

## Example Implementation
Extend AbstractFileInputOperator to read UTF-8 encoded data.

```
public class EncodedDataReader extends AbstractFileInputOperator<String>
{
  public final transient DefaultOutputPort<String> output = new DefaultOutputPort<>();
  protected transient BufferedReader br;

  protected InputStream openFile(Path path) throws IOException
  {
    InputStream is = super.openFile(path);
    br = new BufferedReader(new InputStreamReader(is, StandardCharsets.UTF_8));
    return is;
  }

  @Override
  protected void closeFile(InputStream is) throws IOException
  {
    super.closeFile(is);
    br.close();
    br = null;
  }

  @Override
  protected String readEntity() throws IOException
  {
    return br.readLine();
  }

  @Override
  protected void emit(String tuple)
  {
    output.emit(tuple);
  }
}

```

