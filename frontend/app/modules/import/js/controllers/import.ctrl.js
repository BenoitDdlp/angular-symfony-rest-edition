/**
 *
 */
angular.module('importApp').controller('importCtrl', [
  '$scope',
  '$modal',
  'importService',
  function ($scope, $modal, importService)
  {
    var csvsAsArrays = [],
        fileIsParsed = false,
        fileIsValidated = false,
        fileIsImported = false,

        csvRowSeparator = '\n',
        csvFieldSeparator = ';',
        csvTextDelimiter = '"',
        csvCollectionSeparator = '|',

        selectFileStep = 1,
        validationStep = 2,
        importStep = 3
      ;

    $scope.busy = false;
    $scope.error = false;
    $scope.validationError = true;
    $scope.importResults = {};

    //opens modal
    $scope.startImport = function (entityLbl)
    {
      $scope.entityLbl = entityLbl;
      $scope.header = importService.init(entityLbl);
      var modalInstance = $modal.open({
        templateUrl: 'modules/import/partials/modals/import.html',
        controller : 'importCtrl',
        size       : "lg",
        scope      : $scope
      });
    };

    //on wizard step change
    $scope.changeStep = function (stepNb)
    {
      //goto first step if no file is selected
      if (stepNb != selectFileStep && csvsAsArrays.length < 1)
      {
        $scope.wizard.step(selectFileStep, true);
        return;
      }

      switch (stepNb)
      {
        case validationStep:
          parseFile();

          validateFile();

          break;
        case importStep:
          parseFile();

          validateFile();

          importFile();

          break;
      }
    };

    $scope.retrySend = function (step)
    {
      fileIsImported = fileIsValidated = false;
      $scope.busy = true;
      $scope.wizard.step(step);
    };

    function parseFile()
    {
      if (!fileIsParsed)
      {
        $scope.results = importService.processImport(csvsAsArrays);
        fileIsParsed = true;
        fileIsValidated = false;
        $scope.validationError = true;
      }
    }

    function validateFile()
    {
      //validate
      if (!fileIsValidated)
      {
        $scope.busy = true;
        fileIsValidated = true;
        importService.send($scope.results, "false", function (importResults)
        {
          $scope.importResults = importResults;
          $scope.error = false;
          $scope.busy = false;
          if (_.size($scope.importResults.errors) == 0)
          {
            $scope.validationError = false;
            fileIsImported = false;
          }

        }, function ()
        {
          $scope.error = true;
          $scope.busy = false;
        });
      }
      else
      {
        $scope.busy = false;
      }
    }

    function importFile()
    {

      if (!fileIsImported && !$scope.validationError)
      {
        $scope.busy = true;
        importService.send($scope.results, "true", function (importResults)
        {
          $scope.importResults = importResults;
          $scope.error = false;
          $scope.busy = false;
          fileIsImported = true;

        }, function ()
        {
          $scope.error = true;
          $scope.busy = false;
          fileIsImported = true;
        });
      }
      else
      {
        $scope.busy = false;
      }
    }

    //parses csvs into arrays and put in csvsAsArrays
    // called when files were drop or selected
    $scope.fileChanged = function (isRemoved)
    {
      csvsAsArrays = [];
      fileIsParsed = $scope.busy = false;
      this.$flow.upload();//just update ui

      var i = 0,
          reader = new FileReader(),
          files = this.$flow.files;

      reader.onload = function (onLoadEvent)
      {
        var csvArray = onLoadEvent.target.result.csvToArray({
          rSep: csvRowSeparator,
          fSep: csvFieldSeparator,
          quot: csvTextDelimiter,
          trim: true
        });
        //remove commented rows
        for (var i = 0; i < csvArray.length; i++)
        {
          if (csvArray[i][0].charAt(0) == "#")
          {
            delete csvArray[i];
          }
        }
        csvsAsArrays.push(csvArray);
        readNextFile(++i);
      };

      readNextFile(i);

      function readNextFile(index)
      {
        if (files[index])
        {
          reader.readAsText(files[index].file);
        }
        else if (!isRemoved)
        { //nothing else to read
          $scope.wizard.step(validationStep);
        }
      }
    };

  }])
;
