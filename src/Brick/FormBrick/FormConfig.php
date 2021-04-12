<?php

declare(strict_types=1);

namespace Lle\CruditBundle\Brick\FormBrick;

use Lle\CruditBundle\Brick\AbstractBrickConfig;
use Lle\CruditBundle\Contracts\CrudConfigInterface;
use Lle\CruditBundle\Contracts\DatasourceInterface;
use Lle\CruditBundle\Dto\Field\FormField;
use Lle\CruditBundle\Dto\Path;

class FormConfig extends AbstractBrickConfig
{

    /** @var DatasourceInterface */
    private $dataSource;

    /** @var ?string */
    private $form = null;

    /** @var array */
    private $options = [];

    /** @var FormField[] */
    private $fields = [];

    /** @var ?Path */
    private $successRedirectPath;

    /** @var string */
    private $messageSuccess;

    /** @var string */
    private $messageError;


    public static function new(array $options = []): self
    {
        return new self($options);
    }

    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->form = $options['form'] ?? null;
    }

    public function setSuccessRedirectPath(Path $path): self
    {
        $this->successRedirectPath = $path;
        return $this;
    }

    public function getSuccessRedirectPath(): Path
    {
        return $this->successRedirectPath ?? $this->getCrudConfig()->getPath();
    }

    public function setFlashMessageSuccess(string $message): self
    {
        $this->messageSuccess = $message;
        return $this;
    }

    public function setFlashMessageError(string $message): self
    {
        $this->messageError = $message;
        return $this;
    }

    public function getMessageError(): string
    {
        return $this->messageError ?? 'crudit.message.error';
    }

    public function getMessageSuccess(): string
    {
        return $this->messageSuccess ?? 'crudit.message.success';
    }

    public function getForm(): ?string
    {
        return $this->form;
    }

    public function setForm(?string $form): self
    {
        $this->form = $form;
        return $this;
    }

    public function add(FormField $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function addAuto(array $fields): self
    {
        foreach ($fields as $field) {
            $this->fields[] = FormField::new($field);
        }
        return $this;
    }

    /** @return FormField[] */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function setCrudConfig(CrudConfigInterface $crudConfig): self
    {
        parent::setCrudConfig($crudConfig);
        if ($this->dataSource === null) {
            $this->setDataSource($crudConfig->getDatasource());
        }
        return $this;
    }

    public function setDataSource(DatasourceInterface $dataSource): self
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    public function getDataSource(): DatasourceInterface
    {
        return $this->dataSource;
    }
}
