<?php namespace AlistairShaw\Vendirun\App\Entities\Order\OrderItem;

class Downloadable {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var int
     */
    private $fileSize;

    /**
     * Downloadable constructor.
     * @param $id
     * @param $fileName
     * @param null $fileSize
     */
    public function __construct($id, $fileName, $fileSize = null)
    {
        $this->id = $id;
        $this->fileName = $fileName;
        $this->fileSize = $fileSize;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return int|null
     */
    public function getFileSizeInMB()
    {
        return number_format($this->fileSize / 1024, 3);
    }

}